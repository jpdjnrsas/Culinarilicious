<!DOCTYPE html>
<html>
<head>
    <title>Culinarilicious</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0;background:#0f766e;display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;">

    <div style="background:white;padding:30px;border-radius:12px;width:350px;text-align:center;">

        @yield('content')

    </div>

</body>
</html>