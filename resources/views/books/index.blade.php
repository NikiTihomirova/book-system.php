@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Списък с книги</h1>

    <!-- Търсене -->
    <form method="GET" action="{{ route('books.index') }}">
        <div class="mb-4">
            <input type="text" class="form-control" name="search" placeholder="Търсене по заглавие" value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary">Търси</button>
    </form>

    <!-- Списък с книги -->
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <!-- Проверка дали има изображение -->
                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        <p class="card-text">Цена: {{ number_format($book->price, 2) }} лв</p> <!-- Форматиране на цената -->

                        <!-- Бутон за добавяне в количката -->
                        <form method="POST" action="{{ route('user.cart.add', $book->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Добави в количката</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links('vendor.pagination.bootstrap-4') }}
    </div>

    <!-- Съобщение при празни резултати -->
    @if($books->isEmpty())
        <p>Няма налични книги за показване.</p>
    @endif
</div>
@endsection
