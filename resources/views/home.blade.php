@extends('layouts.app')

@section('content')
<div class="container text-center my-5">
    <h1 class="display-4">{{ __('Добре дошли в Системата за Книги!') }}</h1>
    <p class="lead">{{ __('Тук можете да разглеждате, добавяте книги в кошницата си и управлявате библиотеката си.') }}</p>
    @if($books->isEmpty())
        <p>Няма налични книги.</p>
    @else
        <ul>
            @foreach($books as $book)
                <li>{{ $book->title }} - {{ $book->author->name }} - {{ $book->price }} лв.</li>
            @endforeach
        </ul>
    @endif
@endsection
    @auth
        <div class="mt-4">
            <!-- Линкове за потребители и администратори -->
            @if (auth()->check())
                @if (auth()->user()->role === 'user')
                    <a href="{{ route('user.cart') }}" class="btn btn-primary btn-lg mx-2">{{ __('Моята Кошница') }}</a>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-lg mx-2">{{ __('Разгледай Книги') }}</a>
                @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.books.index') }}" class="btn btn-primary btn-lg mx-2">{{ __('Админ Панел') }}</a>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-lg mx-2">{{ __('Разгледай Книги') }}</a>
                @endif
            @else
                <p>{{ __('Моля, влезте, за да разглеждате книгите и управлявате вашата кошница.') }}</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">{{ __('Вход') }}</a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg mx-2">{{ __('Регистрация') }}</a>
            @endif
        </div>
    @else
        <div class="mt-4">
            <p>{{ __('Моля, влезте, за да разглеждате книгите и управлявате вашата кошница.') }}</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">{{ __('Вход') }}</a>
            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg mx-2">{{ __('Регистрация') }}</a>
        </div>
    @endauth
</div>
@endsection
