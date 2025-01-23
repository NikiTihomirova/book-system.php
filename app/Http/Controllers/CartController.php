<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Book;

class CartController extends Controller
{
    // Преглед на кошницата
    public function index()
    {
        // Вземаме всички артикули в кошницата с данни за съответната книга
        $cartItems = CartItem::with('book')->get();
        $totalPrice = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);

        // Връщаме изгледа с артикули и обща цена
        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    // Добавяне на книга в кошницата
    public function store(Request $request)
    {
        // Валидиране на входа
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Проверка дали книгата вече е в кошницата на текущия потребител
        $cartItem = CartItem::where('user_id', auth()->id())
                            ->where('book_id', $validated['book_id'])
                            ->first();
    
        if ($cartItem) {
            // Ако книгата вече е в кошницата, увеличаваме количеството
            $cartItem->quantity += $validated['quantity'];  // Увеличаваме количеството
            $cartItem->save();
    
            return redirect()->route('cart.index')->with('success', 'Количеството на книгата беше увеличено!');
        }
    
        // Ако книгата не е в кошницата, създаваме нов запис
        CartItem::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'],
            'quantity' => $validated['quantity'],
        ]);
    
        return redirect()->route('cart.index')->with('success', 'Книгата беше добавена в кошницата!');
    }
    


    
    // Актуализиране на количество на артикул в кошницата
    public function update(Request $request, $id)
    {
        // Намираме артикула в кошницата
        $cartItem = CartItem::findOrFail($id);
    
        // Проверка дали потребителят има право да редактира този артикул
        if ($cartItem->user_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Нямате право да редактирате този артикул.');
        }
    
        // Валидиране на новото количество
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Обновяване на количеството на артикула
        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();
    
        // Пренасочване с успех
        return redirect()->route('cart.index')->with('success', 'Количество успешно обновено.');
    }

    // Премахване на артикул от кошницата
    public function destroy(CartItem $cartItem)
    {
        // Изтриване на артикул от кошницата
        $cartItem->delete();

        // Пренасочване с успех
        return redirect()->route('cart.index')->with('success', 'Книгата беше премахната от кошницата!');
    }

    // Изчистване на кошницата
    public function clear()
    {
        // Лог за дебъгване
        \Log::info('Clear cart method called for user: ' . auth()->id());
    
        // Изчистваме всички артикули в кошницата на текущия потребител
        CartItem::where('user_id', auth()->id())->delete();
    
        // Лог за дебъгване след изчистването
        \Log::info('Cart items cleared for user: ' . auth()->id());
    
        // Връщаме потребителя обратно на страницата на кошницата със съобщение за успех
        return redirect()->route('cart.index')->with('success', 'Кошницата беше изчистена!');
    }
    
    

    public function add(Request $request)
{
    $validated = $request->validate([
        'book_id' => 'required|exists:books,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Добавяне на книга в кошницата
    CartItem::create([
        'user_id' => auth()->id(),
        'book_id' => $validated['book_id'],
        'quantity' => $validated['quantity'],
    ]);

    return redirect()->route('cart.index')->with('success', 'Книгата беше добавена в кошницата!');
}

}
