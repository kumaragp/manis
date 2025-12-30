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

<body class="font-inter antialiased overflow-hidden relative bg-neutral-900">

    <div id="bg1" class="fixed inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out">
    </div>

    <div id="bg2" class="fixed inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 ease-in-out">
    </div>

    <div class="fixed inset-0 bg-black/20"></div>

    <header class="relative z-20 w-full bg-[#B28A52] py-2 flex justify-center items-center">
        <div class="flex items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kawasan Industri Terpadu Batang"
                    class="w-20 mr-3 mb-1">
            </a>
            <h1 class="text-white font-bold text-xl leading-tight">
                KAWASAN <br> INDUSTRI TERPADU<br>BATANG
            </h1>
        </div>
    </header>

    <main class="relative z-20 min-h-screen flex flex-col items-center justify-center">
        {{ $slot }}
    </main>

</body>


<script>
    const images = [
        "{{ asset('images/bg1.webp') }}",
        "{{ asset('images/bg2.webp') }}",
        "{{ asset('images/bg3.webp') }}"
    ];

    // PRELOAD
    images.forEach(src => {
        const img = new Image();
        img.src = src;
    });

    let index = 1;
    let active = 1;

    const bg1 = document.getElementById('bg1');
    const bg2 = document.getElementById('bg2');

    bg1.style.backgroundImage = `url('${images[0]}')`;

    setInterval(() => {
        const current = active === 1 ? bg1 : bg2;
        const next = active === 1 ? bg2 : bg1;

        next.style.backgroundImage = `url('${images[index]}')`;
        next.classList.remove('opacity-0');
        current.classList.add('opacity-0');

        active = active === 1 ? 2 : 1;
        index = (index + 1) % images.length;
    }, 5000);
</script>

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