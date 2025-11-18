<x-guest-layout>
    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 w-[600px] text-center shadow-xl">

        {{-- Error Global --}}
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <h3>DEBUG: Ada error!</h3>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <p class="text-white text-sm mb-2">Masuk Sebagai</p>
        <h2 class="text-white font-bold text-2xl mb-4">ADMIN / KARYAWAN</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4 p-1">
            @csrf

            {{-- Email --}}
            <div class="text-left">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email" placeholder="email"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
            </div>

            {{-- Password --}}
            <div class="text-left">
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-white" />
                <div class="relative mt-1">
                    <x-text-input id="password" placeholder="password"
                        class="block w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                        type="password" name="password" required autocomplete="current-password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-10 h-full"
                        onclick="togglePassword('password', 'eyeIcon')">
                        <i id="eyeIcon" class="fa-solid fa-eye-slash text-white"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
            </div>

            {{-- Links --}}
            <div class="mt-4 flex justify-between">
                <a href="{{ route('register') }}" class="text-white text-right text-sm hover:underline">
                    {{ __('Belum Punya Akun?') }}
                </a>
                <a href="{{ route('password.request') }}" class="text-white text-left text-sm hover:underline">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            </div>

            {{-- Submit --}}
            <div class="mt-4 flex justify-center">
                <x-primary-button class="flex justify-center">
                    {{ __('MASUK') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>