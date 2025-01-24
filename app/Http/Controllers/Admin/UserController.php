<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function books()
    {
        $books = Book::all(); // Извлича всички книги от базата
        return view('user.books', compact('books'));
    }

    public function cart()
    {
        $cartItems = auth()->user()->cartItems; // Извлича артикули от количката на текущия потребител
        return view('user.cart', compact('cartItems'));
    }
}
