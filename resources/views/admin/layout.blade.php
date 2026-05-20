<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-black text-white min-h-screen p-4">

        <h1 class="text-xl font-bold mb-6">Culinarilicious Admin</h1>

        <!-- ONLY 3 BUTTONS -->
        <a href="/admin/orders" class="block py-2">Orders</a>
        <a href="/admin/foods" class="block py-2">Foods</a>
        <a href="/admin/reviews" class="block py-2">Reviews</a>

    </div>

    <!-- CONTENT -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

</div>

</body>
</html>