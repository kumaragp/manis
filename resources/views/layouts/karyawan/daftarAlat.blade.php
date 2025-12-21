<x-app-layout :user="Auth::user()">

    <div class="w-full px-4 sm:px-6 lg:px-0">
        <h1 class="text-3xl sm:text-5xl lg:text-6xl
                   font-extrabold text-white text-center
                   pt-20 mb-8">
            DAFTAR ALAT
        </h1>

        <div class="w-full max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">

                @foreach ($alat as $item)
                    <x-alat-card
                        :id="$item['id']"
                        :nama="$item['nama']"
                        :gambar="$item['gambar']"
                        :status="$item['status']"
                        :stok="$item['stok']"
                    />
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>