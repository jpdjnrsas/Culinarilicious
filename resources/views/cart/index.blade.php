@extends('layouts.app')

@section('content')

<h1>🛒 Your Cart</h1>

@if(session('cart') && count(session('cart')) > 0)

<table border="1" cellpadding="10">
    <tr>
        <th>Food</th>
        <th>Price</th>
        <th>Qty</th>
    </tr>

    @foreach(session('cart') as $item)
    <tr>
        <td>{{ $item['name'] }}</td>
        <td>₱{{ $item['price'] }}</td>
        <td>{{ $item['quantity'] }}</td>
    </tr>
    @endforeach

</table>

<br>

<form method="POST" action="/checkout">
    @csrf
    <button>✅ Checkout</button>
</form>

@else
<p>Cart is empty</p>
@endif

@endsection