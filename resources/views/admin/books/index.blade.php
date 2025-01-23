@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление на Книги</h1>

    <!-- Бутон за създаване на нова книга -->
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">Добави нова книга</a>

    <!-- Форма за търсене и филтриране -->
    <form method="GET" action="{{ route('admin.books.index') }}">
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Търси по заглавие" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="genre" class="form-control">
                    <option value="">Всички жанрове</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="Мин. цена" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="Макс. цена" value="{{ request('max_price') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Търси</button>
            </div>
        </div>
    </form>

    <!-- Списък с книги (в две колонки) -->
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="Изображение на {{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        <p class="card-text">Цена: {{ $book->price }} лв</p>
                        
                        <!-- Бутон за редактиране -->
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">Редактирай</a>
                        
                        <!-- Бутон за изтриване -->
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Изтрий</button>
                        </form>

                        <!-- Бутон за добавяне в кошницата -->
                        <form action="{{ route('cart.add') }}" method="POST" style="margin-top: 10px;">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" style="width: 100px;">
                            <button type="submit" class="btn btn-primary btn-sm">Добави в кошницата</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection
