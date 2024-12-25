<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">
    <meta name="keywords" content="kitchen, wardrobes, closets, others, ">
    <meta name="author" content="Tecozi">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags (para redes sociais) -->
    <meta property="og:title" content="{{ config('app.name', 'Tecozi') }}">
    <meta property="og:description"
        content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'Tecozi') }}">
    <meta name="twitter:description"
        content="Somos uma empresa familiar, iniciámos a nossa atividade em 2010. A paixão pela área, o profissionalismo e o rigor do nosso gerente, tornou-nos numa referência de qualidade no setor. ">

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
    <div id="scrollToTopButton" class="fixed bottom-4 right-4 z-50 cursor-pointer animate-float">
        <img id="scrollToTopImage" src="{{ asset('/assets/images/home/scrollup.png') }}" alt="floating image"
            class="w-12 h-12" />
    </div>

    </div>

    @inertia

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>

        const scrollToTopButton = document.getElementById('scrollToTopButton');
        const scrollToTopImage = document.getElementById('scrollToTopImage');

        const originalImageSrc = '/assets/images/home/scrollup.png';
        const whiteImageSrc = '/assets/images/home/tt.png';

        // Função para rolar até o topo
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Animação suave
            });
        }

        scrollToTopButton.addEventListener('click', scrollToTop);

        function checkScrollPosition() {
            const scrollThreshold = document.body.scrollHeight * 0.6;

            if (window.scrollY > scrollThreshold) {
                scrollToTopImage.src = whiteImageSrc;
            } else {
                scrollToTopImage.src = originalImageSrc;
            }

            if (window.scrollY > 300) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        }

        window.addEventListener('scroll', checkScrollPosition);

        scrollToTopButton.style.display = 'none';

        checkScrollPosition();
    </script>

</body>

</html>
