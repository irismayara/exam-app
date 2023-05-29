<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/746/746980.png?w=740&t=st=1682274472~exp=1682275072~hmac=811aa447451594e02f56dda4d111f2c7855324b7162b09be773771fb704731a6" sizes="16x16 32x32" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                <div class=" mx-auto">
                    <img src="https://cdn-icons-png.flaticon.com/512/1179/1179186.png?w=740&t=st=1685393363~exp=1685393963~hmac=d1b7407b53d4bd73d8d7d8934ddd1bc3c61d293819cd9c91d24b848a9c633b20" class="w-48 h-48  mx-auto" alt="error">
                    <p class="text-secondary text-center mt-4">SORRY! SOMETHING WAS WRONG.</p>
                </div>
            </div>
        </div>
    </body>
</html>