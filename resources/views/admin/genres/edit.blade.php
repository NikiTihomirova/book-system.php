@extends('layouts.app')

@if(auth()->check())
    @if (auth()->user()->role === 'admin')
        <a href="{{ route('admin.books.index') }}" class="{{ request()->is('admin/books*') ? 'active' : '' }}">Админ панел</a>
    @endif

    @if (auth()->user()->role === 'user')
        <a href="{{ route('user.dashboard') }}" class="{{ request()->is('user/dashboard*') ? 'active' : '' }}">Потребителско табло</a>
    @endif
@else
    <a href="{{ route('login') }}" class="btn btn-info">Моля, влезте в профила си</a>
@endif

@section('content')
    <h1>{{ isset($genre) ? 'Редакция на жанр' : 'Добави жанр' }}</h1>

    <!-- Съобщения за грешка или успех -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ isset($genre) ? route('admin.genres.update', $genre->id) : route('admin.genres.store') }}" method="POST">
        @csrf
        @if(isset($genre))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Име</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $genre->name ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Запази</button>
    </form>

    <!-- Стилове за съобщения за успех и грешки -->
    <style>
        .alert {
            margin-top: 20px;
        }
    </style>
@endsection
