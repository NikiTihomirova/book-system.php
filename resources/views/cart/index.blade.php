@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Моята Кошница</h1>

    @if($cartItems->isEmpty())
        <p>Кошницата ви е празна. <a href="{{ route('books.index') }}">Върнете се към магазина и добавете продукти.</a></p>
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
                        <!-- Снимка на книгата -->
                        <td>
                            <img src="{{ asset('storage/' . $item->book->image) }}" alt="Снимка на {{ $item->book->title }}" width="80">
                        </td>

                        <!-- Заглавие на книгата -->
                        <td>{{ $item->book->title }}</td>

                        <!-- Количество -->
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="update-cart-form">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 50px;">
                                <button type="submit" class="btn btn-warning btn-sm">Обнови</button>
                            </form>
                        </td>

                        <!-- Цена на елемента -->
                        <td>{{ number_format($item->book->price * $item->quantity, 2, ',', ' ') }} лв.</td>

                        <!-- Премахване на елемента -->
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

        <p><strong>Общо: <span id="total-price">{{ number_format($totalPrice, 2, ',', ' ') }} лв</span></strong></p>
        
        <!-- Изчистване на кошницата -->
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Изчисти кошницата</button>
        </form>
    @endif
</div>

<script>
    // Обработчик за AJAX заявка при обновяване на количството
    document.querySelectorAll('.update-cart-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(form);
            let quantityInput = form.querySelector('input[name="quantity"]');
            let quantity = quantityInput.value;
            let url = form.action;

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Обновяване на общата сума
                    document.getElementById('total-price').innerText = data.totalPrice;
                    alert(data.success); // Показване на съобщение за успех
                } else {
                    alert('Грешка при обновяването на количеството.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Грешка при обновяването на количеството.');
            });
        });
    });
</script>
@endsection
