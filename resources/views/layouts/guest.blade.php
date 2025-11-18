<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <title>{{ config('app.name', 'Manis') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        .background-change {
            background-size: cover;
            background-position: center;
            transition: background-image 2s ease-in-out;
            background-attachment: fixed;
        }
    </style>

</head>

<body class="font-inter antialiased overflow-y-hidden background-change" id="background-body">

    {{-- Header --}}
    <div class="top-0 w-full bg-[#B28A52] py-2 flex justify-center items-center z-10">
        <div class="flex items-center">
            <a href="{{ route("home") }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kawasan Industri Terpadu Batang" class="w-20 mr-3 mb-1">
            </a>
            <h1 class="text-white font-bold text-xl">KAWASAN <br> INDUSTRI TERPADU<br>BATANG</h1>
        </div>
    </div>

    {{-- Content slot --}}
    <div class="min-h-screen flex flex-col items-center justify-center">
        {{ $slot }}
    </div>

    <script>
        const images = [
            '{{ asset('images/bg1.webp') }}',
            '{{ asset('images/bg2.webp') }}',
            '{{ asset('images/bg3.webp') }}'
        ];

        let currentIndex = 0;
        const body = document.getElementById('background-body');
        const intervalTime = 5000;

        function changeBackground() {
            body.style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length;
        }

        changeBackground();
        setInterval(changeBackground, intervalTime);
    </script>
</body>

<!-- Icon Mata -->
<script defer>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
        }
    }
</script>

</html>