<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-10">
                <x-application-logo class="h-12 w-12 text-indigo-600" />
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-indigo-600">Culinarilicious</p>
                    <h1 class="text-2xl font-semibold text-slate-900">Simple food delivery made better</h1>
                </div>
            </div>

            <div class="w-full max-w-[12rem] rounded-[2rem] bg-white p-2">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
