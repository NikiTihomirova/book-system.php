@extends('layouts.app')

@section('content')
    <!-- Навигация за роли -->
    <nav>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.books.index') }}">Админ панел</a>
        @elseif(auth()->user()->isUser())
            <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
        @endif
    </nav>

    <h1>{{ isset($author) ? 'Редакция на автор' : 'Добави автор' }}</h1>

    <!-- Съобщение за успех -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Изход от системата -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Изход</a>

    <!-- Форма за добавяне/редактиране на автор -->
    <form action="{{ isset($author) ? route('admin.authors.update', $author->id) : route('admin.authors.store') }}" method="POST">
        @csrf
        @if(isset($author))
            @method('PUT')
        @endif
        
        <!-- Поле за име на автора -->
        <div class="mb-3">
            <label for="name" class="form-label">Име</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $author->name ?? old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Запази</button>
    </form>
@endsection
