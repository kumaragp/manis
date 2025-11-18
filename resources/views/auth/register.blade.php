<x-guest-layout>
    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 w-[600px] text-center shadow-xl">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="text-left">
                <x-input-label class="text-white" for="name" :value="__('Nama Pengguna')" />
                <x-text-input id="name" placeholder="username"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4 text-left">
                <x-input-label class="text-white" for="email" :value="__('Email')" />
                <x-text-input id="email" placeholder="email"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 text-left">
                <x-input-label class="text-white" for="password" :value="__('Kata Sandi')" />
                <x-text-input id="password" placeholder="password"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="password" name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 text-left">
                <x-input-label class="text-white" for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" placeholder="password confirmation"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="text-right">
                <a class="text-sm text-white hover:underline rounded-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Sudah Punya Akun?') }}
                </a>
            </div>

            <div class="flex items-center justify-center">
                <x-primary-button class="flext justify-center">
                    {{ __('Registrasi') }}
                </x-primary-button>
        </form>
    </div>
</x-guest-layout>