<x-app-layout :user="Auth::user()">
    
    <div class="w-full">
        <h1 class="text-6xl font-extrabold text-white text-center pt-6 mb-8">
            DAFTAR ALAT
        </h1>

        {{-- Container dengan Max Width --}}
        <div class="w-full max-w-7xl mx-auto">
            
            {{-- Grid dengan !important via style --}}
    <div class="grid 
                grid-cols-1     {{-- mobile --}}
                sm:grid-cols-2  {{-- tablet --}}
                lg:grid-cols-3  {{-- laptop --}}
                xl:grid-cols-4  {{-- monitor besar --}}
                gap-8 w-full">

                @foreach($alats as $alat)
                    <div style="width: 100%; min-width: 0;">
                        <x-alat-card 
                            :id="$alat['id']"
                            :nama="$alat['nama']"
                            :gambar="$alat['gambar']"
                            :status="$alat['status']"
                        />
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</x-app-layout>