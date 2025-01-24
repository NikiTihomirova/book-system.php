@extends('layouts.app')

@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}" class="{{ request()->is('admin/books*') ? 'active' : '' }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}" class="{{ request()->is('user/dashboard*') ? 'active' : '' }}">Потребителско табло</a>
@endif

@section('content')
    <h1>Жанрове</h1>

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

    <a href="{{ route('admin.genres.create') }}" class="btn btn-primary mb-3">Добави жанр</a>

    <!-- Таблица за жанровете -->
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
                        
                        <!-- Потвърждение за изтриване -->
                        <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този жанр?');">
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
        {{ $genres->links() }}
    </div>

    <!-- Подобрение на потвърждението за изтриване с JavaScript (по избор) -->
    <script>
        document.querySelectorAll('form[onsubmit="return confirm(\'Сигурни ли сте, че искате да изтриете този жанр?\');"]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!confirm('Сигурни ли сте, че искате да изтриете този жанр?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
