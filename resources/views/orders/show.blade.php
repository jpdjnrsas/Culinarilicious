@extends('layouts.app')

@section('content')

<h1>📦 Order Details</h1>

<div class="card">

<h3>Order #{{ $order->id }}</h3>

<p><b>Status:</b> {{ ucfirst($order->status) }}</p>
<p><b>ETA:</b> {{ $order->eta ?? 'Waiting...' }}</p>

<!-- ✅ RECEIPT BUTTON -->

@if($order->status == 'delivered') <a href="/orders/{{ $order->id }}/receipt"> <button style="margin-bottom:10px;">📄 Download Receipt</button> </a>
@endif

{{-- TIMELINE --}}

<div class="timeline">
    <div class="step {{ $order->status == 'pending' ? 'active' : '' }}">Pending</div>
    <div class="step {{ in_array($order->status, ['on delivery','delivered']) ? 'active' : '' }}">On Delivery</div>
    <div class="step {{ $order->status == 'delivered' ? 'active' : '' }}">Delivered</div>
</div>

<h4>Items</h4>
<ul>
@foreach($order->items as $item)
    <li>{{ $item->food->name }} x {{ $item->quantity }}</li>
@endforeach
</ul>

{{-- CANCEL --}}
@if(!in_array($order->status, ['delivered','cancelled']))

<form method="POST" action="/orders/{{ $order->id }}/cancel">
    @csrf
    <button class="btn-danger">Cancel Order</button>
</form>
@endif

{{-- REVIEW --}}
@if($order->status == 'delivered')

<hr>

<h3>⭐ Rate Your Order</h3>

<form method="POST" action="/reviews">
@csrf

<input type="hidden" name="order_id" value="{{ $order->id }}">
<input type="hidden" name="rating" id="ratingValue" required>

<!-- STARS -->

<div class="stars" id="starContainer">
    @for($i=1;$i<=5;$i++)
        <span data-value="{{ $i }}">★</span>
    @endfor
</div>

<p id="ratingText" class="muted">Click a star to rate</p>

<textarea name="comment" placeholder="Write feedback about food, delivery, experience..." required></textarea>

<button id="submitBtn">Submit Review</button>

</form>

@endif

</div>

<style>
.timeline {
    display:flex;
    gap:8px;
    margin:15px 0;
}

.step {
    flex:1;
    text-align:center;
    padding:8px;
    background:#e5e7eb;
    border-radius:8px;
    font-size:13px;
}

.step.active {
    background:#0f766e;
    color:#fff;
}

/* ⭐ STARS */
.stars {
    display:flex;
    gap:6px;
    margin:10px 0;
}

.stars span {
    font-size:30px;
    cursor:pointer;
    color:#ccc;
    transition:0.2s;
}

.stars span:hover {
    transform:scale(1.2);
}

.stars span.active {
    color:gold;
}

textarea {
    width:100%;
    padding:10px;
    border-radius:8px;
    margin-top:10px;
}
</style>

<script>
const stars = document.querySelectorAll('#starContainer span');
const input = document.getElementById('ratingValue');
const text = document.getElementById('ratingText');

const labels = {
    1:"😡 Bad",
    2:"😕 Okay",
    3:"😐 Average",
    4:"😊 Good",
    5:"🤩 Excellent"
};

// hover preview
stars.forEach(s => {
    s.addEventListener('mouseover', () => {
        const v = s.dataset.value;

        stars.forEach(x => {
            x.classList.toggle('active', x.dataset.value <= v);
        });
    });

    s.addEventListener('click', () => {
        const v = s.dataset.value;
        input.value = v;

        stars.forEach(x => {
            x.classList.toggle('active', x.dataset.value <= v);
        });

        text.innerText = labels[v];
    });
});

// restore when mouse leaves
document.getElementById('starContainer').addEventListener('mouseleave', () => {
    const v = input.value;

    stars.forEach(x => {
        x.classList.toggle('active', x.dataset.value <= v);
    });
});
</script>
<script>
const form=document.querySelector('form');
const btn=document.getElementById('submitBtn');

if(form && btn){
    form.addEventListener('submit',()=>{
        btn.innerText="Submitting...";
        btn.disabled=true;
    });
}
</script>

@endsection
