<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Списък с всички жанрове.
     */
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Форма за създаване на нов жанр.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Създаване на нов жанр.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Genre::create($request->all());

        return redirect()->route('genres.index')->with('success', 'Жанрът е добавен успешно!');
    }

    /**
     * Форма за редактиране на съществуващ жанр.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Актуализиране на данни за жанр.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->update($request->all());

        return redirect()->route('genres.index')->with('success', 'Данните за жанра са обновени успешно!');
    }

    /**
     * Изтриване на жанр.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Жанрът е изтрит успешно!');
    }
}
