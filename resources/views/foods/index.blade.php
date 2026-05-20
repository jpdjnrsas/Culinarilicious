@extends('layouts.app')

@section('content')

<div class="foods-page">

    <div class="foods-header">

        <div>
            <h1>🍔 Available Foods</h1>
            <p>Fresh and delicious meals ready for delivery</p>
        </div>

    </div>

    <div class="foods-grid">

        @foreach($foods as $food)

        <div class="food-card">

            {{-- IMAGE --}}
            @if($food->image)

                <img src="{{ asset('storage/'.$food->image) }}"
                     class="food-image">

            @else

                <div class="food-placeholder">
                    🍔
                </div>

            @endif

            {{-- CONTENT --}}
            <div class="food-content">

                <h3>{{ $food->name }}</h3>

                <div class="price">
                    ₱{{ number_format($food->price, 2) }}
                </div>

                @if($food->stock > 0)

                    <div class="stock available">
                        🟢 Stock: {{ $food->stock }}
                    </div>

                    <form method="POST"
                          action="/cart/add/{{ $food->id }}">

                        @csrf

                        <button class="add-btn">
                            Add to Cart
                        </button>

                    </form>

                @else

                    <div class="stock out">
                        🔴 OUT OF STOCK
                    </div>

                    <button class="disabled-btn" disabled>
                        Unavailable
                    </button>

                @endif

            </div>

        </div>

        @endforeach

    </div>

    {{-- PAGINATION --}}
    <div class="pagination-box">
        {{ $foods->links() }}
    </div>

</div>

<style>

/* PAGE */
.foods-page{
    padding:35px;
    max-width:1400px;
    margin:auto;
}

/* HEADER */
.foods-header{
    margin-bottom:30px;
}

.foods-header h1{
    font-size:40px;
    color:#111827;
    margin-bottom:8px;
}

.foods-header p{
    color:#6b7280;
    font-size:16px;
}

/* GRID */
.foods-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:25px;
}

/* CARD */
.food-card{
    background:white;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.25s;
    display:flex;
    flex-direction:column;
    min-height:430px;
}

.food-card:hover{
    transform:translateY(-5px);
    box-shadow:0 16px 35px rgba(0,0,0,0.14);
}

/* IMAGE */
.food-image{
    width:100%;
    height:220px;
    object-fit:cover;
}

/* NO IMAGE */
.food-placeholder{
    width:100%;
    height:220px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:60px;
    background:#f3f4f6;
}

/* CONTENT */
.food-content{
    padding:20px;
    display:flex;
    flex-direction:column;
    flex:1;
}

.food-content h3{
    font-size:24px;
    margin-bottom:10px;
    color:#111827;
}

/* PRICE */
.price{
    font-size:24px;
    font-weight:700;
    color:#0f766e;
    margin-bottom:14px;
}

/* STOCK */
.stock{
    margin-bottom:18px;
    font-weight:600;
}

.available{
    color:#15803d;
}

.out{
    color:#dc2626;
}

/* BUTTONS */
.add-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#0f766e,#14b8a6);
    color:white;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:0.2s;
}

.add-btn:hover{
    transform:translateY(-2px);
}

.disabled-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#d1d5db;
    color:#6b7280;
    font-weight:700;
}

/* PAGINATION */
.pagination-box{
    margin-top:35px;
}

/* TABLET */
@media(max-width:1100px){

    .foods-grid{
        grid-template-columns:repeat(3,1fr);
    }

}

/* MOBILE */
@media(max-width:768px){

    .foods-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

/* SMALL MOBILE */
@media(max-width:520px){

    .foods-grid{
        grid-template-columns:1fr;
    }

    .foods-page{
        padding:20px;
    }

}

</style>

@endsection