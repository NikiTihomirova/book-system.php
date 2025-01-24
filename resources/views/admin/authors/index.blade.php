@extends('layouts.app')

@section('content')
    <!-- Навигация в зависимост от ролята -->
    <nav>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.books.index') }}" class="btn btn-info mb-3">Админ панел</a>
        @elseif(auth()->user()->isUser())
            <a href="{{ route('user.dashboard') }}" class="btn btn-info mb-3">Потребителско табло</a>
        @endif
    </nav>

    <!-- Съобщения за успех -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Автори</h1>
    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary mb-3">Добави нов автор</a>

    <!-- Таблица с автори -->
    <table class="table table-bordered table-striped">
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

                        <!-- Потвърждение преди изтриване -->
                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този автор?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Изтриване</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $authors->links() }}
    </div>
@endsection
