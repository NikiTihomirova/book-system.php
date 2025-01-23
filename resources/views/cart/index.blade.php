@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Моята Кошница</h1>

    @if($cartItems->isEmpty())
        <p>Кошницата ви е празна.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Книга</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Общо</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <!-- Снимка -->
                        <td>
                            <img src="{{ asset('storage/' . $item->book->image) }}" alt="Снимка на {{ $item->book->title }}" width="80">
                        </td>

                        <!-- Заглавие -->
                        <td>{{ $item->book->title }}</td>

                        <!-- Количество -->
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 50px;">
                                <button type="submit" class="btn btn-warning btn-sm">Обнови</button>
                            </form>
                        </td>

                        <!-- Цена -->
                        <td>{{ number_format($item->book->price * $item->quantity, 2) }} лв.</td>

                        <!-- Изтриване -->
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Общо: {{ $totalPrice }} лв</strong></p>
        <form action="{{ route('cart.clear') }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Изчисти кошницата</button>
</form>

    @endif
</div>
@endsection
