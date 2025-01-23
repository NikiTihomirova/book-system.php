<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre; // Добавено е тук
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; 

class BookController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    
    // Ограничаваме достъпа само за администратори
    $this->middleware(function ($request, $next) {
        if (auth()->user()->role != 'admin') {
            abort(403, 'Нямате достъп до тази страница');
        }
        return $next($request);
    })->only(['create', 'store', 'edit', 'update', 'destroy']);
}

public function index(Request $request)
{
    $query = Book::query();

    // Търсене по заглавие
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Филтриране по жанр
    if ($request->has('genre') && $request->genre != '') {
        $query->where('genre_id', $request->genre);
    }

    // Филтриране по цена
    if ($request->has('min_price') && $request->min_price != '') {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price') && $request->max_price != '') {
        $query->where('price', '<=', $request->max_price);
    }

    // Извличане на книгите
    $books = $query->with('author', 'genre')->paginate(10);

    // Зареждане на жанровете за филтъра
    $genres = Genre::all();

    // Връщане на изгледа
    return view('admin.books.index', compact('books', 'genres'));
}


    public function home()
    {
        $books = Book::latest()->take(10)->get(); // Последно добавени книги
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
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Валидация за изображение
    ]);

    // Ако има качено изображение
    if ($request->hasFile('image')) {
        // Качване на изображението в папката "images/books" и съхраняване на пътя
        $imagePath = $request->file('image')->store('images/books', 'public');
        $validatedData['image'] = $imagePath;
    }

    // Създаване на нова книга с добавеното изображение
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
     * Актуализиране на данни за книга.
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

    // Обработваме качването на изображение
    if ($request->hasFile('image')) {
        try {
            $imagePath = $request->file('image')->store('images/books', 'public');
            $validatedData['image'] = $imagePath;
        } catch (\Exception $e) {
            // Логване на грешка
            \Log::error('Грешка при качване на изображение: ' . $e->getMessage());
        }
    }

    // Актуализираме данните за книгата
    $book->update($validatedData);

    return redirect()->route('admin.books.index')->with('success', 'Данните за книгата са обновени успешно!');
}


    /**
     * Изтриване на книга.
     */
    public function destroy(Book $book)
    {
        $book->delete();
    
        return redirect()->route('admin.books.index')->with('success', 'Книгата е изтрита успешно!');
    }
}
