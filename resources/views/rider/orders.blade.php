@extends('layouts.app')

@section('content')

<h1>🚴 Rider Orders</h1>

<div class="grid">

@forelse($orders as $order)

<div class="card">

    <h3>Order #{{ $order->id }}</h3>

    <p><b>Status:</b> {{ ucfirst($order->status) }}</p>
    <p><b>ETA:</b> {{ $order->eta ?? 'Not set' }}</p>
    <p><b>Customer:</b> {{ $order->user->name }}</p>

    {{-- 👉 GO TO DETAILS PAGE --}}
    <a href="/rider/orders/{{ $order->id }}">
        <button class="btn-secondary">View Details</button>
    </a>

    {{-- 📸 SHOW PROOF IF EXISTS --}}
    @if($order->proof_image)
        <div style="margin-top:10px;">
            <img src="{{ asset('storage/'.$order->proof_image) }}"
                 style="width:100px; border-radius:10px;">
        </div>
    @endif

</div>

@empty

<div class="card">
    <p class="muted">No orders assigned yet.</p>
</div>

@endforelse

</div>

@endsection