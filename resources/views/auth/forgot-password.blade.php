<x-guest-layout>
    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 w-[600px] text-center shadow-xl">
        <div class="text-white">
            {{ __('Lupa kata sandi? Tidak masalah. Cukup beritahu kami alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi anda melalui email.') }}
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="text-left text-white mb-2">
                <x-input-label class="text-white" for="email" :value="__('Email')" />
                <x-text-input id="email" placeholder="email"
                    class="block mt-1 w-full bg-transparent border border-white/40 text-white placeholder-white focus:outline-none focus:border-white"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="text-right">
                <a href="{{ route('login') }}" class="text-white text-sm hover:underline">
                    {{ __('Kembali ke halaman login?') }}
                </a>
            </div>

            <div class="mt-4 flex justify-center">
                <x-primary-button class="flex justify-center">
                    {{ __('Kirim') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>