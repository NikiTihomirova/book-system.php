@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Списък с книги</h1>

    <!-- Форма за търсене на книги -->
    <form method="GET" action="{{ route('books.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Търсене по заглавие или автор" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Търси
            </button>
        </div>
    </form>

    @if($books->isEmpty())
        <p>Няма налични книги.</p>
    @else
        <div class="row">
            @foreach($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Изображение на книгата -->
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/150x200?text=Няма+изображение" class="card-img-top" alt="Без изображение">
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">Автор: <a href="{{ route('author.books', $book->author->id) }}">{{ $book->author->name }}</a></p>

                            <!-- Форма за добавяне в количката -->
                            <form method="POST" action="{{ route('user.cart.add', $book->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-shopping-cart"></i> Добави в количката
                                </button>
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
    @endif
</div>
@endsection
