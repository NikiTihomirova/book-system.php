@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактиране на книга</h1>
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Заглавие</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="form-group">
            <label for="author_id">Автор</label>
            <select name="author_id" class="form-control" id="author_id" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $author->id == old('author_id', $book->author_id) ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="genre_id">Жанр</label>
            <select name="genre_id" class="form-control" id="genre_id" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $genre->id == old('genre_id', $book->genre_id) ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" name="price" class="form-control" id="price" value="{{ old('price', $book->price) }}" required>
        </div>

        <div class="form-group">
            <label for="image">Снимка на книгата</label>
            @if($book->image)
                <div>
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="max-width: 100px; max-height: 100px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" id="image">
        </div>

        <button type="submit" class="btn btn-primary">Запази</button>
    </form>
</div>
@endsection
