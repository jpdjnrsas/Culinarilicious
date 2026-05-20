@extends('layouts.app')

@section('content')

<h1>📦 My Orders</h1>

{{-- EMPTY STATE --}}
@if($orders->isEmpty())

<div class="card empty-state">
    <div class="empty-icon">📭</div>
    <h2>No Orders Yet</h2>
    <p class="muted">You haven’t placed any orders yet. Start exploring delicious meals!</p>

```
<a href="/foods">
    <button>🍔 Browse Foods</button>
</a>
```

</div>

@else

{{-- ORDERS GRID --}}

<div class="grid">

@foreach($orders as $order)

<div class="card order-card">

```
<div class="order-header">
    <h3>Order #{{ $order->id }}</h3>

    <span class="badge
        @if($order->status == 'delivered') badge-success
        @elseif($order->status == 'cancelled') badge-danger
        @else badge-warning
        @endif
    ">
        {{ ucfirst($order->status) }}
    </span>
</div>

<p class="muted">
    {{ $order->created_at->format('F d, Y') }}
</p>

<ul class="items-preview">
    @foreach($order->items->take(2) as $item)
        <li>{{ $item->food->name }} x {{ $item->quantity }}</li>
    @endforeach

    @if($order->items->count() > 2)
        <li class="muted">+ {{ $order->items->count() - 2 }} more</li>
    @endif
</ul>

<a href="/orders/{{ $order->id }}">
    <button style="margin-top:10px;">View Details</button>
</a>
```

</div>

@endforeach

</div>

@endif

<style>

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 50px 30px;
}

.empty-icon {
    font-size: 50px;
    margin-bottom: 10px;
}

/* ORDER CARD */
.order-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* HEADER */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* ITEMS */
.items-preview {
    margin: 10px 0;
    padding-left: 18px;
}

.items-preview li {
    margin-bottom: 3px;
}

/* BADGES */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-danger {
    background: #fee2e2;
    color: #7f1d1d;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

</style>

@endsection
