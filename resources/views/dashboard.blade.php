@extends('layouts.app')

@section('content')

<div class="culina-page">

    <div class="culina-container">

        {{-- HERO --}}
        <section class="culina-hero">

            <div class="hero-top">
                <h1>👋 Welcome to <span>Culinarilicious</span></h1>
                <p>Fresh meals. Fast delivery. Clean experience.</p>
            </div>

            <a href="/account" class="hero-user">

                {{-- PROFILE --}}
                @if(auth()->check())
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="avatar">
                    @else
                        <div class="avatar-fallback">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </div>
                    @endif

                    <div class="user-info">
                        <h3>{{ auth()->user()->name }}</h3>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                @endif

            </a>

        </section>

        {{-- DASHBOARD CARDS --}}
        <section class="culina-grid">

            {{-- BUYER --}}
            @if(auth()->check() && auth()->user()->role == 'buyer')

                <a href="/foods" class="card">
                    🍔 <div>
                        <h3>Browse Foods</h3>
                        <p>Explore menus & meals</p>
                    </div>
                </a>

                <a href="/cart" class="card">
                    🛒 <div>
                        <h3>My Cart</h3>
                        <p>Review selected items</p>
                    </div>
                </a>

                <a href="/orders" class="card">
                    📦 <div>
                        <h3>My Orders</h3>
                        <p>Track deliveries</p>
                    </div>
                </a>

                <a href="/account" class="card">
                    👤 <div>
                        <h3>Account</h3>
                        <p>Profile settings</p>
                    </div>
                </a>

            @endif

            {{-- ADMIN --}}
            @if(auth()->check() && auth()->user()->role == 'admin')

                <a href="/admin/orders" class="card">
                    📦 <div>
                        <h3>Orders</h3>
                        <p>Manage all orders</p>
                    </div>
                </a>

                <a href="/admin/foods" class="card">
                    🍔 <div>
                        <h3>Foods</h3>
                        <p>Edit menu & inventory</p>
                    </div>
                </a>

                <a href="/admin/sales" class="card">
                    💰 <div>
                        <h3>Sales</h3>
                        <p>Revenue overview</p>
                    </div>
                </a>

                <a href="/admin/reviews" class="card">
                    ⭐ <div>
                        <h3>Reviews</h3>
                        <p>Customer feedback</p>
                    </div>
                </a>

            @endif

            {{-- RIDER --}}
            @if(auth()->check() && auth()->user()->role == 'rider')

                <a href="/rider/orders" class="card">
                    🚴 <div>
                        <h3>Deliveries</h3>
                        <p>Assigned orders</p>
                    </div>
                </a>

                <a href="/account" class="card">
                    👤 <div>
                        <h3>Profile</h3>
                        <p>Update details</p>
                    </div>
                </a>

            @endif

        </section>

    </div>

</div>

<style>

/* FULL CENTER FIX (your previous issue) */
.culina-page{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:40px 20px;
    box-sizing:border-box;
    background:linear-gradient(135deg,#0f172a,#0f766e);
}

/* MAIN WRAPPER */
.culina-container{
    width:100%;
    max-width:1150px;
}

/* HERO */
.culina-hero{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:28px;
    padding:40px;
    color:white;
    margin-bottom:25px;
}

.hero-top h1{
    font-size:40px;
    margin-bottom:8px;
}

.hero-top span{
    color:#facc15;
}

.hero-top p{
    opacity:0.85;
}

/* USER */
.hero-user{
    margin-top:20px;
    display:flex;
    align-items:center;
    gap:15px;
    background:rgba(255,255,255,0.10);
    padding:15px;
    border-radius:16px;
    width:fit-content;
    text-decoration:none;
    color:white;
    transition:0.25s;
    cursor:pointer;
}

.hero-user:hover{
    background:rgba(255,255,255,0.16);
    transform:scale(1.02);
}

.avatar{
    width:65px;
    height:65px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid white;
}

.avatar-fallback{
    width:65px;
    height:65px;
    border-radius:50%;
    background:white;
    color:#0f766e;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-size:24px;
}

/* GRID */
.culina-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:18px;
}

/* CARD */
.card{
    display:flex;
    gap:15px;
    align-items:center;
    text-decoration:none;
    color:white;
    padding:22px;
    border-radius:18px;

    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.12);

    transition:0.25s;
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.18);
}

/* TEXT */
.card h3{
    margin:0;
    font-size:20px;
}

.card p{
    margin:4px 0 0;
    font-size:14px;
    opacity:0.85;
}

/* MOBILE */
@media(max-width:768px){
    .culina-hero{
        padding:25px;
    }

    .hero-top h1{
        font-size:30px;
    }

    .card{
        flex-direction:column;
        text-align:center;
    }
}

</style>

@endsection