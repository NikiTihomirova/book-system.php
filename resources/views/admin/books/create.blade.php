@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавяне на книга</h1>
    <form method="POST" action="{{ route('books.store') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Заглавие</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label">Автор</label>
            <select class="form-control" id="author_id" name="author_id" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="genre_id" class="form-label">Жанр</label>
            <select class="form-control" id="genre_id" name="genre_id" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" class="btn btn-primary">Добави</button>
    </form>
</div>
@endsection
