@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <h1>Жанрове</h1>
    <a href="{{ route('admin.genres.create') }}" class="btn btn-primary mb-3">Добави жанр</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Име</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $genre)
                <tr>
                    <td>{{ $genre->id }}</td>
                    <td>{{ $genre->name }}</td>
                    <td>
                        <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn btn-warning btn-sm">Редакция</a>
                        <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Изтриване</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
