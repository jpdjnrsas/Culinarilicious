@extends('layouts.app')

@section('content')

<div class="container">

    <h1>👑 Admin Dashboard</h1>

    <!-- STATS -->
    <div class="grid">
        <div>💰 Sales: ₱{{ $totalSales }}</div>
        <div>📦 Orders: {{ $totalOrders }}</div>
        <div>🍔 Products: {{ $totalProducts }}</div>
    </div>

    <hr>

    <!-- FOOD MANAGEMENT -->
    <h2>🍔 Foods</h2>

    @foreach($foods as $food)
        <div class="card">
            <strong>{{ $food->name }}</strong>
            <p>₱{{ $food->price }}</p>
        </div>
    @endforeach

    <hr>

    <!-- ORDERS -->
    <h2>📦 Orders</h2>

    @foreach($orders as $order)
        <div class="card">
            <p>Order #{{ $order->id }}</p>
            <p>User: {{ $order->user->name }}</p>
            <p>Status: {{ $order->status }}</p>

            @if($order->rider_id === null && !in_array($order->status, ['assigned','on delivery','delivered','cancelled']))

                <form method="POST" action="/admin/orders/{{ $order->id }}/assign">
                    @csrf

                    <select name="rider_id">
                        {{-- riders list --}}
                    </select>

                    <button>Assign Rider</button>
                </form>

            @else
                <p style="color:gray;">🚫 Already assigned / cannot reassign</p>
            @endif
        </div>
    @endforeach

    <hr>

    <!-- REVIEWS -->
    <h2>⭐ Reviews & Feedback</h2>

    @foreach($reviews as $review)
        <div class="card">
            <p>User: {{ $review->user->name }}</p>
            <p>Food: {{ $review->food->name }}</p>
            <p>Rating: {{ $review->rating }}/5</p>
            <p>{{ $review->comment }}</p>
        </div>
    @endforeach

</div>

@endsection