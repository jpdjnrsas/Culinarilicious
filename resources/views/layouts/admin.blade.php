<!DOCTYPE html>
<html>
<head>
    <title>Culinarilicious Admin</title>
    @vite(['resources/css/app.css'])
</head>

<body style="margin:0; font-family:Inter, Arial; background:#f4f6f9;">

<div style="display:flex; min-height:100vh;">

    <!-- SIDEBAR -->
    <div style="width:240px; background:#111827; color:white; padding:20px; display:flex; flex-direction:column;">

        <h2 style="margin-bottom:30px;">🍽 Culinarilicious</h2>

        <!-- NAV LINKS -->
        <a href="/admin/orders" style="padding:10px; color:white; text-decoration:none;">📦 Orders</a>
        <a href="/admin/foods" style="padding:10px; color:white; text-decoration:none;">🍔 Foods</a>
        <a href="/admin/reviews" style="padding:10px; color:white; text-decoration:none;">⭐ Reviews</a>

        <div style="margin-top:auto;">

            <!-- LOGOUT FIXED -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="
                    width:100%;
                    margin-top:20px;
                    padding:10px;
                    background:#dc2626;
                    color:white;
                    border:none;
                    cursor:pointer;
                ">
                    🚪 Logout
                </button>
            </form>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div style="flex:1; padding:25px;">

        @yield('content')

    </div>

</div>

</body>
</html>