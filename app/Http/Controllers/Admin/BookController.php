<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Конструктор с middleware за проверка на достъпа.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Нямате достъп до тази страница.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Списък с всички книги, с възможност за търсене и филтриране.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Търсене по заглавие
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Филтриране по жанр
        if ($request->filled('genre')) {
            $query->where('genre_id', $request->genre);
        }

        // Филтриране по цена
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Зареждаме книгите и съответните жанрове/автори
        $books = $query->with(['author', 'genre'])->paginate(10);
        $genres = Genre::all();

        return view('admin.books.index', compact('books', 'genres'));
    }

    /**
     * Начална страница с последно добавени книги.
     */
    public function home()
    {
        $books = Book::latest()->take(10)->get();
        return view('home', compact('books'));
    }

    /**
     * Форма за създаване на нова книга.
     */
    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('admin.books.create', compact('authors', 'genres'));
    }

    /**
     * Създаване на нова книга.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images/books', 'public');
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Книгата беше добавена успешно!');
    }

    /**
     * Форма за редактиране на съществуваща книга.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('admin.books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Обновяване на книга.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validatedData['image'] = $request->file('image')->store('images/books', 'public');
        }

        $book->update($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Книгата беше обновена успешно!');
    }

    /**
     * Изтриване на книга.
     */
    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Книгата беше изтрита успешно!');
    }
}
