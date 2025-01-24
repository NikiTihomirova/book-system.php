@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Вашата количка</h1>
    @if($cartItems->isEmpty())
        <p>Количката е празна.</p>
    @else
        <ul class="list-group">
            @foreach($cartItems as $item)
                <li class="list-group-item">
                    <strong>{{ $item->book->title }}</strong> - {{ $item->quantity }} бр.
                    <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Премахни</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
