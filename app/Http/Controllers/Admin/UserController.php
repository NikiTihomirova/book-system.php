<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Само авторизирани потребители
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role != 'admin') { // Само администратори имат достъп
                abort(403, 'Нямате достъп до тази страница');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::all(); // Вземи всички потребители
        return view('admin.users.index', compact('users')); // Изведи потребителите
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Намери потребителя по ID
        return view('admin.users.edit', compact('user')); // Покажи формата за редактиране
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Намери потребителя по ID
        $user->update($request->all()); // Обнови потребителските данни
        return redirect()->route('admin.users.index'); // Пренасочи към списъка с потребители
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); // Намери потребителя по ID
        $user->delete(); // Изтрий потребителя
        return redirect()->route('admin.users.index'); // Пренасочи към списъка с потребители
    }
    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

}
