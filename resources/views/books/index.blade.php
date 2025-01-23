@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Списък с книги</h1>

    <div class="row">
        @foreach($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        <p class="card-text">Цена: {{ $book->price }} лв</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection
