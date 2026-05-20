<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Culinarilicious</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary text-white font-sans">

<!-- NAVBAR -->
<nav class="flex justify-between items-center px-10 py-4 bg-primaryDark shadow-md">
    <h1 class="text-xl font-bold">Culinarilicious</h1>

    <div class="space-x-3">
        @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="bg-danger hover:bg-dangerDark px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-white text-primary px-4 py-2 rounded">
                Login
            </a>

            <a href="{{ route('register') }}" class="bg-info text-white px-4 py-2 rounded">
                Register
            </a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<div class="flex flex-col justify-center items-center h-[80vh] text-center px-4">
    <h1 class="text-4xl font-bold mb-4">
        Welcome to Culinarilicious 🍽️
    </h1>

    <p class="text-lg mb-6 text-gray-200">
        Discover, order, and enjoy delicious food anytime.
    </p>

    <div class="space-x-4">
        <a href="/foods" class="bg-white text-primary px-6 py-3 rounded-lg shadow hover:bg-gray-200">
            Browse Foods
        </a>

        <a href="/cart" class="bg-danger px-6 py-3 rounded-lg shadow hover:bg-dangerDark">
            View Cart
        </a>
    </div>
</div>

</body>
</html>