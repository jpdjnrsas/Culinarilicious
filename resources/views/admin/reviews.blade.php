@extends('layouts.app')

@section('content')

<h1>Reviews & Feedback</h1>

@foreach($reviews as $review)
<div class="card">
    <h3>⭐ {{ $review->rating }}/5</h3>
    <p>{{ $review->comment }}</p>

    <p><b>Order:</b> #{{ $review->order_id }}</p>
    <p><b>User:</b> {{ $review->user->name }}</p>
</div>
@endforeach

@endsection