@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="page-title">🍔 Food Management</h1>

    {{-- TOP BUTTONS --}}
    <div class="top-actions">

        <a href="/admin/foods/create" class="action-btn add-btn">
            ➕ Add New Food
        </a>

        <a href="/admin/foods/delete-page" class="action-btn delete-btn">
            🗑 Delete Foods
        </a>

    </div>

    {{-- FOOD GRID --}}
    <div class="food-grid">

        @forelse($foods as $food)

            <div class="food-card">

                {{-- IMAGE --}}
                @if($food->image)
                    <img src="{{ asset('storage/'.$food->image) }}"
                         class="food-image">
                @else
                    <div class="no-image">
                        No Image
                    </div>
                @endif

                <div class="food-info">

                    <h3>{{ $food->name }}</h3>

                    <p>₱{{ number_format($food->price, 2) }}</p>

                    <span class="stock">
                        Stock: {{ $food->stock }}
                    </span>

                </div>

                <a href="/admin/foods/{{ $food->id }}/edit"
                   class="edit-btn">
                    ✏️ Edit Food
                </a>

            </div>

        @empty

            <div class="empty-box">
                No foods available.
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
   <div class="simple-pagination">

    {{-- PREVIOUS --}}
    @if ($foods->onFirstPage())

        <span class="page-btn disabled">
            Previous
        </span>

    @else

        <a href="{{ $foods->previousPageUrl() }}" class="page-btn">
            Previous
        </a>

    @endif

    {{-- NEXT --}}
    @if ($foods->hasMorePages())

        <a href="{{ $foods->nextPageUrl() }}" class="page-btn">
            Next
        </a>

    @else

        <span class="page-btn disabled">
            Next
        </span>

    @endif

</div>

<style>

.simple-pagination{
    margin-top:35px;
    display:flex;
    justify-content:center;
    gap:15px;
}

.page-btn{
    padding:12px 24px;
    border-radius:12px;
    background:#0f766e;
    color:white;
    text-decoration:none;
    font-weight:700;
    transition:0.2s;
}

.page-btn:hover{
    background:#115e59;
    transform:translateY(-2px);
}

.disabled{
    opacity:0.5;
    pointer-events:none;
}

</style>

</div>

<style>

.container{
    max-width:1200px;
    margin:auto;
    padding:30px;
}

.page-title{
    color:white;
    margin-bottom:25px;
}

/* TOP BUTTONS */
.top-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:30px;
}

.action-btn{
    padding:22px;
    border-radius:18px;
    text-decoration:none;
    color:white;
    font-size:20px;
    font-weight:bold;
    text-align:center;
    transition:0.25s;
}

.action-btn:hover{
    transform:translateY(-4px);
}

.add-btn{
    background:linear-gradient(135deg,#0f766e,#14b8a6);
}

.delete-btn{
    background:linear-gradient(135deg,#991b1b,#dc2626);
}

/* GRID */
.food-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

/* CARD */
.food-card{
    background:white;
    border-radius:20px;
    padding:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    text-align:center;
}   

.food-card h3{
    color:#111827 !important;
    font-size:22px;
    margin-top:15px;
    margin-bottom:8px;
}

.food-card p{
    color:#4b5563 !important;
    font-size:15px;
    margin-bottom:15px;
}

.food-card img{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:16px;
}

/* IMAGE */
.food-image{
    width:100%;
    height:220px;
    object-fit:cover;
    display:block;
}

/* NO IMAGE */
.no-image{
    height:220px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#1f2937;
    color:white;
}

/* INFO */
.food-info{
    padding:18px;
    color:white;
}

.food-info h3{
    margin-bottom:8px;
}

.stock{
    opacity:0.8;
}

/* EDIT BUTTON */
.edit-btn{
    display:block;
    margin:15px;
    text-align:center;
    background:#facc15;
    color:black;
    padding:12px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
}

/* EMPTY */
.empty-box{
    color:white;
    opacity:0.8;
}

@media(max-width:768px){

    .top-actions{
        grid-template-columns:1fr;
    }

}

/* FORCE DARK TEXT INSIDE FOOD CARDS */
.food-card h2,
.food-card h3,
.food-card h4,
.food-card p,
.food-card span,
.food-card small{
    color:#111827 !important;
}

/* STOCK TEXT */
.stock-text{
    color:#374151 !important;
    font-weight:600;
}

/* PAGE TITLE */
.page-title{
    color:#111827 !important;
    font-weight:800;
}
</style>

@endsection