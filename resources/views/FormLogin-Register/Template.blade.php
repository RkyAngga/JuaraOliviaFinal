<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Lapor.Pal!</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/login.js', 'resources/js/app.js'])
    <style>
        .form-field:focus-within {
            transform: scale(1.01);
        }
        .error-message {
            opacity: 0;
            animation: fadeIn 0.3s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .loading-button {
            position: relative;
            overflow: hidden;
        }
        .loading-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }
        @keyframes loading {
            to { left: 100%; }
        }
        .custom-logo {
            width: auto;
            height: 40px;
        }

        header {
            transition: background-color 0.3s ease;
        }
        header.scrolled {
            background-color: #FEC23E;
        }
    </style>
    @yield('additional_styles')
</head>
<body class="bg-putih min-h-screen flex flex-col justify-between font-poppins">
    <!-- Header -->
    <header class="w-full bg-white shadow-lg fixed top-0 z-50" id="header">
        <div class="container mx-auto px-8 py-6 flex justify-between items-center">
            <img src="{{ asset('img/logo/Hitam2.png') }}" alt="LAPOR PAL" class="custom-logo resize-logo" id="logo">
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 mt-2 mb-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full">
        <!-- Gambar ilustrasi kota Malang -->
        <img src="{{ asset('img/logo/Footer.png') }}" alt="Ilustrasi Kota Malang" class="w-full h-auto" style="max-height: 250px; object-fit: cover;">

        <!-- Background kuning dengan copyright text -->
        <div class="w-full bg-kuning text-center py-4">
            <p class="text-hitam text-[13px]">Copyright © 2025 Pemerintah Kota Malang. - All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const logo = document.getElementById('logo');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 0) {
                    header.classList.add('scrolled');
                    logo.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                    logo.classList.remove('scrolled');
                }
            });
        });
    </script>
    @yield('additional_scripts')
</body>
</html>
