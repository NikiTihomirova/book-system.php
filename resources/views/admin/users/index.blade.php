@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Потребители</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Добави нов потребител</a>

    <!-- Съобщения за успех или грешки -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Търсене -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Търсене по име или имейл" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Търси</button>
        </div>
    </form>

    <!-- Списък с потребители -->
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Име</th>
                <th>Имейл</th>
                <th>Роля</th>
                <th>Дата на регистрация</th> <!-- Допълнителна колона -->
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td> <!-- Дата на регистрация -->
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Редактирай</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този потребител?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Изтрий</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
