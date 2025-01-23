<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController; 

// Рутове за аутентикация
Auth::routes();

// Начална страница
Route::get('/', [BookController::class, 'home'])->name('home');

// Администраторски маршрути
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('books', BookController::class);
});

// Автори
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);

// Книги
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Потребителски маршрути
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Маршрути за кошницата
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
});
