    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Culinarilicious</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        margin: 0;
        display: flex;
        min-height: 100vh;
        background: url('https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
        background-size: cover;
    }

    /* 🌫 BLUR BACKGROUND */
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        backdrop-filter: blur(14px);
        background: rgba(0,0,0,0.35);
        z-index: 0;
    }

    /* ================= SIDEBAR ================= */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        padding: 24px 18px;
        display: flex;
        flex-direction: column;
        z-index: 10;
        color: white;
    }

    /* ROLE COLORS */
    body.buyer .sidebar {
        background: linear-gradient(180deg, #0f766e, #115e59);
    }

    body.rider .sidebar {
        background: linear-gradient(180deg, #0f172a, #1e3a8a);
    }

    body.admin .sidebar {
        background: linear-gradient(180deg, #000000, #1f1f1f);
    }

    .sidebar h2 {
        margin-bottom: 20px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 10px;
        margin-bottom: 6px;
        border-radius: 10px;
        display: block;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,0.15);
    }

    .sidebar a.active {
        background: rgba(255,255,255,0.25);
        font-weight: bold;
    }

    .sidebar form {
        margin-top: auto;
    }

    .sidebar button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 10px;
        background: #ef4444;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    /* ================= CONTENT ================= */
    .content {
        min-height: 100vh;
        padding: 40px;
        display: flex;
        justify-content: center;
        position: relative;
        z-index: 1;

        width: 100%;
    }

    /* ONLY APPLY SIDEBAR SPACING WHEN SIDEBAR EXISTS */
    body:not(.dashboard-page) .content {
        margin-left: 260px;
    }

    body.dashboard-page .content {
        margin-left: 0;
    }

    /* GLASS CONTAINER */
    .container {
        width: 100%;
        max-width: 1200px;
        background: rgba(255,255,255,0.82);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.18);
    }

    /* ================= CARDS ================= */
    .card {
        background: white;
        padding: 18px;
        border-radius: 14px;
        margin-bottom: 15px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    }

    /* ================= BUTTONS ================= */
    button {
        background: #0f766e;
        color: white;
        border: none;
        padding: 10px 14px;
        border-radius: 10px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.9;
    }

    .btn-danger {
        background: #ef4444;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* GRID */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
    }

    h1,h2,h3 { margin-top: 0; }

    </style>
    </head>

    <body class="
    {{ auth()->check() ? auth()->user()->role : '' }}
    {{ request()->routeIs('home') ? 'dashboard-page' : '' }}
    ">
    @if(request()->path() != '/')

    @if(!request()->is('dashboard'))
    <div class="sidebar">
        <h2 class="logo">
            <a href="/" style="text-decoration:none; color:inherit;">
                🍽 Culinarilicious
            </a>
        </h2>

        @auth
            @if(auth()->user()->role === 'buyer')
                <a href="/foods">🍔 Foods</a>
                <a href="/cart">🛒 Cart</a>
                <a href="/orders">📦 My Orders</a>
                <a href="/account">👤 Account</a>
            @endif

            @if(auth()->user()->role === 'rider')
                <a href="/rider/orders">🚴 Rider Dashboard</a>
                <a href="/account">👤 Account</a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="/admin/foods">🍔 Foods</a>
                <a href="/admin/orders">📦 Orders</a>
                <a href="/admin/sales">💰 Sales</a>
                <a href="/admin/reviews">⭐ Reviews</a>
                <a href="/account">👤 Account</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </div>
    @endif
    @endif

    <div class="content">
        @if(request()->is('dashboard'))
            {{-- DASHBOARD WITHOUT CONTAINER --}}
            @yield('content')
        @else
            {{-- NORMAL PAGES --}}
            <div class="container">
                @yield('content')
            </div>
        @endif
    </div>

    <!-- 🔔 TOAST NOTIFICATIONS -->

    <div id="toast-container"></div>

    <style>
    #toast-container{
        position:fixed;
        top:20px;
        right:20px;
        z-index:9999;
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .card{
    animation:fadeUp 0.4s ease;
    }

    @keyframes fadeUp{
    from{
    opacity:0;
    transform:translateY(20px);
    }
    to{
    opacity:1;
    transform:translateY(0);
    }
    }

    button{
    transition:0.2s ease;
    }

    button:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
    }


    .toast{
        padding:12px 18px;
        border-radius:10px;
        color:#fff;
        font-weight:600;
        min-width:220px;
        box-shadow:0 10px 25px rgba(0,0,0,0.2);
        animation:slideIn 0.3s ease;
    }

    .toast.success{background:#16a34a;}
    .toast.error{background:#ef4444;}

    @keyframes slideIn{
        from{transform:translateX(100%);opacity:0;}
        to{transform:translateX(0);opacity:1;}
    }
    </style>

    <script>
    function showToast(message,type='success'){
        const toast=document.createElement('div');
        toast.className=`toast ${type}`;
        toast.innerText=message;

        document.getElementById('toast-container').appendChild(toast);

        setTimeout(()=>toast.remove(),3000);
    }
    </script>

    @if(session('success'))

    <script>showToast("{{ session('success') }}","success")</script>

    @endif

    @if(session('error'))

    <script>showToast("{{ session('error') }}","error")</script>

    @endif

    </body>
    </html>