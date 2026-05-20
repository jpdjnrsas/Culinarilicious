@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">🗑 Delete Foods</h1>

    <div class="food-grid">

        @foreach($foods as $food)

            <div class="food-card">

                @if($food->image)
                    <img src="{{ asset('storage/'.$food->image) }}"
                         class="food-image">
                @endif

                <div class="food-info">

                    <h3>{{ $food->name }}</h3>

                    <p>₱{{ number_format($food->price,2) }}</p>

                    <form method="POST"
                          action="/admin/foods/{{ $food->id }}">

                        @csrf
                        @method('DELETE')

                        <button class="delete-btn"
                            onclick="return confirm('Delete this food?')">
                            Delete Food
                        </button>

                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

<style>

.container{
    max-width:1200px;
    margin:auto;
    padding:30px;
}

.title{
    color:black;
    margin-bottom:25px;
}

.food-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.food-card{
    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(10px);
    border-radius:20px;
    overflow:hidden;
}

.food-image{
    width:100%;
    height:220px;
    object-fit:cover;
}

.food-info{
    padding:18px;
    color:black;
}

.delete-btn{
    width:100%;
    margin-top:10px;
    background:#dc2626;
    color:white;
    border:none;
    padding:12px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

</style>

@endsection