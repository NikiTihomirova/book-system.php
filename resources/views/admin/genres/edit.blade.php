@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <h1>{{ isset($genre) ? 'Редакция на жанр' : 'Добави жанр' }}</h1>
    <form action="{{ isset($genre) ? route('admin.genres.update', $genre->id) : route('admin.genres.store') }}" method="POST">
        @csrf
        @if(isset($genre))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Име</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $genre->name ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-success">Запази</button>
    </form>
@endsection
