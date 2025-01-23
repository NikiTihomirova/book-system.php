@extends('layouts.app')
@if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.books.index') }}">Админ панел</a>
@endif

@if (auth()->user()->role === 'user')
    <a href="{{ route('user.dashboard') }}">Потребителско табло</a>
@endif

@section('content')
    <h1>{{ isset($author) ? 'Редакция на автор' : 'Добави автор' }}</h1>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Изход</a>

    <form action="{{ isset($author) ? route('admin.authors.update', $author->id) : route('admin.authors.store') }}" method="POST">
        @csrf
        @if(isset($author))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Име</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $author->name ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-success">Запази</button>
    </form>
@endsection
