<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container text-center my-5">
    <h1 class="display-4">Добре дошли в Системата за Книги!</h1>
    <p class="lead">Тук можете да разглеждате, добавяте книги в кошницата си и управлявате библиотеката си.</p>

    <div class="mt-4">
        <!-- Линкове за потребители -->
        @if (auth()->user()->role === 'user')
            <a href="{{ route('user.cart') }}" class="btn btn-primary btn-lg mx-2">Моята Кошница</a>
            <a href="{{ route('books.index') }}" class="btn btn-secondary btn-lg mx-2">Разгледай Книги</a>
        @endif

        <!-- Линкове за администратори -->
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.books.index') }}" class="btn btn-primary btn-lg mx-2">Админ Панел</a>
            <a href="{{ route('books.index') }}" class="btn btn-secondary btn-lg mx-2">Разгледай Книги</a>
        @endif
    </div>
</div>
@endsection
