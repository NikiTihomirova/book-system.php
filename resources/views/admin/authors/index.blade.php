@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <h1>Автори</h1>
    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary mb-3">Добави автор</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Име</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-warning btn-sm">Редакция</a>
                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display: inline-block;">
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
