<?php

namespace App\Http\Controllers;

use App\Models\Book;

class PublicController extends Controller
{
    // Търсене на книги по заглавие
    public function search(Request $request)
    {
        $query = $request->input('query');  // Вземете стойността от търсачката
        $books = Book::where('title', 'like', '%' . $query . '%')->get();  // Потърсете книги по заглавие
        return view('public.books.search', compact('books', 'query'));  // Върнете изглед с резултатите
    }
}

