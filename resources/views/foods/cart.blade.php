@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Your Cart</h1>

@if(count($cart) > 0)

@foreach($cart as $id => $item)
<div class="bg-white p-4 rounded shadow mb-3 flex justify-between">

    <div>
        <h2 class="font-bold">{{ $item['name'] }}</h2>
        <p>₱{{ $item['price'] }} × {{ $item['quantity'] }}</p>
    </div>

    <a href="/cart/remove/{{ $id }}" class="text-red-500">Remove</a>

</div>
@endforeach

<form method="POST" action="/checkout">
    @csrf
    <button class="w-full bg-green-600 text-white py-3 rounded mt-4">
        Checkout
    </button>
</form>

@else
<p>No items in cart.</p>
@endif

@endsection