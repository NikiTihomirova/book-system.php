@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <div class="container">
        <h1>Редактиране на потребител: {{ $user->name }}</h1>
        
        <!-- Формуляр за редактиране на потребител -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Това указва, че формата е за update -->

            <div class="form-group">
                <label for="name">Име:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="email">Имейл:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="role">Роля:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Потребител</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Запази промените</button>
            </div>
        </form>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Назад към потребители</a>
    </div>
@endsection
