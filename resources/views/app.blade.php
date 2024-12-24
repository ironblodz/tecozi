<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">
    <meta name="keywords" content="kitchen, wardrobes, closets, others, ">
    <meta name="author" content="Tecozi">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags (para redes sociais) -->
    <meta property="og:title" content="{{ config('app.name', 'Tecozi') }}">
    <meta property="og:description" content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'Tecozi') }}">
    <meta name="twitter:description" content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/home/favicon.png') }}" type="image/png">

    <title inertia>{{ config('app.name', 'Tecozi') }}</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>