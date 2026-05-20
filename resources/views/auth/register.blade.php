<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Culinarilicious</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;

            /* ✅ FIX: uses same “dark teal base” instead of strong gradient */
            background: #2c5364;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;

            /* ✅ FIX: match login text tone (neutral dark, not teal) */
            color: #1f2d3a;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus, select:focus {
            outline: none;

            /* ✅ FIX: softer match (same as modern login focus style) */
            border-color: #2c5364;
        }

        button {
            width: 100%;
            padding: 12px;

            /* ✅ FIX: keep consistent primary color */
            background: #2c5364;

            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1e3c47;
        }

        .link {
            margin-top: 15px;
            font-size: 14px;
        }

        .link a {
            color: #2c5364;
            text-decoration: none;
            font-weight: bold;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>🍽 Register</h2>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <input type="text" name="name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="buyer">Buyer</option>
            <option value="rider">Rider</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
    </form>

    <div class="link">
        Already have an account? <a href="/login">Login</a>
    </div>
</div>

</body>
</html>