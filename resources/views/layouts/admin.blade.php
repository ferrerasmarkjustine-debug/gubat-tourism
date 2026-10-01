<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LGU Admin Portal — {{ config('app.name', 'Gubat Tourism') }}</title>
    <meta name="description" content="LGU Admin Portal — Municipality of Gubat Tourism Office">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite compiled Bootstrap & Custom CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Admin-only navigation (no public navbar here) --}}
    @include('super-admin.partials.nav')

    <!-- Page Content -->
    <main class="flex-grow-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('partials.footer')

    {{-- Bootstrap JS CDN fallback – ensures dropdowns work even without Vite dev server --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmRh3B6wI4kj6/S6/d3bEz0RpQT"
            crossorigin="anonymous"></script>

</body>
</html>
