{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pekerja Formal DKI Jakarta')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">

    <style>
        /* Body & Layout */
        body { 
            margin: 0; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            /* Ubah background dasar menjadi #ededed agar menyatu sempurna tanpa ada sela putih */
            background-color: #ededed; 
            color: #1F2937; 
        }
        main { flex: 1; }
        footer { flex-shrink: 0; }

        /* Card hover efek */
        .card-hover:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        /* Memperbesar ukuran tombol zoom in/out bawaan Leaflet */
        .leaflet-control-zoom-in,
        .leaflet-control-zoom-out {
            width: 44px !important;
            height: 44px !important;
            line-height: 44px !important;
            font-size: 24px !important;
        }

        /* Navbar hover + active */
        nav a { transition: color 0.3s, font-weight 0.3s; }
        nav a:hover { color: #60A5FA; }
        nav a.active { color: #3B82F6; font-weight: 700; }
        nav a.active:hover { color: #2563EB; }

        /* Map z-index agar tidak menutupi header */
        .leaflet-container { z-index: 0; }
    </style>
</head>

<body>

    @include('partials.header')

    <main class="pt-20 w-full transition-all duration-300">
        @yield('content')
    </main>

    <div class="w-full transition-all duration-300">
        @include('partials.footer')
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @stack('scripts')

    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js" 
        onload="renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '$', right: '$', display: false}
            ]
        });">
    </script>

</body>
</html>