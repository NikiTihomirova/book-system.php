<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Book;

class CartController extends Controller
{
    /**
     * Преглед на кошницата
     */
    public function index()
    {
        $cartItems = CartItem::with('book')
            ->where('user_id', auth()->id()) // Вземаме само артикулите на текущия потребител
            ->get();

        $totalPrice = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Добавяне на книга в кошницата
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $validated['book_id'],
            ],
            [
                'quantity' => 0,
            ]
        );

        $cartItem->quantity += $validated['quantity'];
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Книгата беше добавена или обновена в кошницата!');
    }

    /**
     * Актуализиране на количество на артикул в кошницата
     */
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Нямате право да редактирате този артикул.');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Количество успешно обновено.');
    }

    /**
     * Премахване на артикул от кошницата
     */
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Нямате право да премахнете този артикул.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Книгата беше премахната от кошницата!');
    }

    /**
     * Изчистване на кошницата
     */
    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'Кошницата беше изчистена!');
    }
}
