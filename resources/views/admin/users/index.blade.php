@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <div class="container">
        <h1>Потребители</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добави нов потребител</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Имейл</th>
                    <th>Роля</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Редактирай</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
