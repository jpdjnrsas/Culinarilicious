@extends('layouts.app')

@section('content')

<h1>📦 Admin Orders</h1>

{{-- 🟡 PENDING --}}
<h2>🟡 Pending Orders (Today)</h2>
@if(session('error'))
    <div style="background:#ffdddd; padding:10px; border-radius:8px; margin-bottom:10px;">
        ❌ {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div style="background:#ddffdd; padding:10px; border-radius:8px; margin-bottom:10px;">
        ✅ {{ session('success') }}
    </div>
@endif
@if($pendingOrders->isEmpty())
    <p class="muted">No pending orders today.</p>
@else
<div class="grid">
@foreach($pendingOrders as $order)
<div class="card">
    <h3>Order #{{ $order->id }}</h3>
    <p><b>Customer:</b> {{ $order->user->name }}</p>
    <p><b>Status:</b> {{ $order->status }}</p>
    <p><b>Rider:</b> {{ $order->rider->name ?? 'Not assigned' }}</p>

    <a href="/admin/orders/{{ $order->id }}">
        <button class="btn-secondary">View Details</button>
    </a>
</div>
@endforeach
</div>
@endif

<hr>

{{-- 🟢 FINISHED --}}
<h2>🟢 Finished Orders (Today)</h2>

@if($finishedOrders->isEmpty())
    <p class="muted">No finished orders today.</p>
@else
<div class="grid">
@foreach($finishedOrders as $order)
<div class="card">
    <h3>Order #{{ $order->id }}</h3>
    <p><b>Customer:</b> {{ $order->user->name }}</p>
    <p><b>Status:</b> {{ $order->status }}</p>

    <a href="/admin/orders/{{ $order->id }}">
        <button class="btn-secondary">View</button>
    </a>
</div>
@endforeach
</div>
@endif

@endsection