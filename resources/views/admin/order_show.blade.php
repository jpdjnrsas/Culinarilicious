@extends('layouts.app')

@section('content')

<h1>📦 Admin Order</h1>

<div class="card">

<p><b>Customer:</b> {{ $order->user->name }}</p>
<p><b>Status:</b> {{ $order->status }}</p>
<p><b>Rider:</b> {{ $order->rider->name ?? 'Not assigned' }}</p>

@if($order->status != 'delivered' && $order->status != 'cancelled')

<h3>Assign Rider</h3>

<form method="POST" action="/admin/orders/{{ $order->id }}/assign">
@csrf

<select name="rider_id">
<option>Select Rider</option>
@foreach($riders as $r)
<option value="{{ $r->id }}">{{ $r->name }}</option>
@endforeach
</select>

<button>Assign</button>
</form>

@endif

<hr>

@if($order->proof_image)

<h3>📸 Delivery Proof</h3>

<img src="{{ asset('storage/'.$order->proof_image) }}"
style="width:250px;border-radius:12px;cursor:pointer"
onclick="openImg(this.src)">

@endif

</div>

<div id="modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.8);justify-content:center;align-items:center">
<img id="modalImg" style="max-width:90%">
</div>

<script>
function openImg(src){
    document.getElementById('modal').style.display='flex';
    document.getElementById('modalImg').src=src;
}

document.getElementById('modal').onclick=()=> {
    document.getElementById('modal').style.display='none';
}
</script>

@endsection