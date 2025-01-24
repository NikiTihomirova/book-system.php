<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;

class UserController extends Controller
{
    /**
     * Потребителско табло.
     */
    public function dashboard()
    {
        // Проверява дали потребителят е логнат
        if (auth()->guest()) {
            return redirect()->route('login')->with('error', 'Моля, влезте в акаунта си.');
        }

        return view('user.dashboard');
    }

    /**
     * Показва списъка с книги.
     */
    public function books()
    {
        $books = Book::all(); // Извлича всички книги от базата
        return view('user.books', compact('books'));
    }

    /**
     * Показва количката на текущия потребител.
     */
    public function cart()
    {
        // Проверява дали потребителят е логнат
        if (auth()->guest()) {
            return redirect()->route('login')->with('error', 'Моля, влезте в акаунта си.');
        }

        $cartItems = auth()->user()->cartItems; // Извлича артикулите от количката на текущия потребител
        return view('user.cart', compact('cartItems'));
    }

    /**
     * Добавя книга към количката.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
            ],
            [
                'quantity' => 0,
            ]
        );

        $cartItem->quantity += $request->quantity;
        $cartItem->save();

        return redirect()->route('user.cart')->with('success', 'Книгата е добавена в количката.');
    }

    /**
     * Премахва артикул от количката.
     */
    public function removeFromCart($id)
    {
        $cartItem = CartItem::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$cartItem) {
            return redirect()->route('user.cart')->with('error', 'Артикулът не е намерен.');
        }

        $cartItem->delete();

        return redirect()->route('user.cart')->with('success', 'Артикулът е премахнат от количката.');
    }

    /**
     * Изпразва количката на потребителя.
     */
    public function clearCart()
    {
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('user.cart')->with('success', 'Количката е изпразнена.');
    }
}
