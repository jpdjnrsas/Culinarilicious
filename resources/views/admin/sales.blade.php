@extends('layouts.app')

@section('content')

<h1>💰 Sales Dashboard</h1>

{{-- KPI CARDS --}}

<div class="grid stats-grid">

```
<div class="card stat-card">
    <h4>Total Sales</h4>
    <h2>₱{{ number_format($totalSales ?? 0, 2) }}</h2>
    <p class="muted">All completed transactions</p>
</div>

<div class="card stat-card">
    <h4>Total Orders</h4>
    <h2>{{ $totalOrders }}</h2>
    <p class="muted">Delivered orders only</p>
</div>

<div class="card stat-card">
    <h4>Average Order</h4>
    <h2>₱{{ number_format($averageOrder, 2) }}</h2>
    <p class="muted">Per successful order</p>
</div>
```

</div>

<hr style="margin:25px 0;">

<h2>📦 Completed Orders</h2>

@if($orders->isEmpty())

<div class="card empty-state">
    <h3>No completed sales yet</h3>
    <p class="muted">Sales will appear once orders are delivered.</p>
</div>

@else

<div class="grid">

@foreach($orders as $order)

<div class="card order-card">

```
<div class="order-top">
    <h3>Order #{{ $order->id }}</h3>
    <span class="badge badge-success">Delivered</span>
</div>

<p class="muted">
    {{ $order->created_at->format('F d, Y h:i A') }}
</p>

<ul class="items-preview">
    @foreach($order->items->take(2) as $item)
        <li>{{ $item->food->name }} x {{ $item->quantity }}</li>
    @endforeach

    @if($order->items->count() > 2)
        <li class="muted">+ {{ $order->items->count() - 2 }} more</li>
    @endif
</ul>

<div class="order-footer">
    <h3>₱{{ number_format($order->total_price ?? 0, 2) }}</h3>

    <a href="/admin/orders/{{ $order->id }}">
        <button class="btn-secondary">View</button>
    </a>
</div>
```

</div>

@endforeach

</div>

@endif

<style>

/* KPI GRID */
.stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

/* STAT CARDS */
.stat-card h4 {
    margin-bottom: 5px;
    color: #64748b;
}

.stat-card h2 {
    margin: 5px 0;
    font-size: 28px;
}

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 40px;
}

/* ORDER CARD */
.order-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* TOP */
.order-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* ITEMS */
.items-preview {
    margin: 10px 0;
    padding-left: 18px;
}

/* FOOTER */
.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* BADGE */
.badge-success {
    background: #d1fae5;
    color: #065f46;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

</style>

@endsection
