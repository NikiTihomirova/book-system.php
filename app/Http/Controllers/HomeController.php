<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;  // Добавете този use

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::latest()->take(5)->get(); // Последно добавени книги
        return view('home', compact('books'));  // Предавайте данните на изгледа
    }
}
