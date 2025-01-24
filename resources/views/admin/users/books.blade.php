@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Списък с книги</h1>
    @if($books->isEmpty())
        <p>Няма налични книги.</p>
    @else
        <ul class="list-group">
            @foreach($books as $book)
                <li class="list-group-item">
                    <strong>{{ $book->title }}</strong> от {{ $book->author }}
                    <form method="POST" action="{{ route('user.cart.add', $book->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Добави в количката</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
