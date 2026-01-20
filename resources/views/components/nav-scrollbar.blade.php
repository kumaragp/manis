<div class="fixed top-16 left-0 right-0 z-40 flex justify-center pt-16" >
    <div class="inline-flex rounded-full bg-[#0A3B65] p-1.5 shadow-lg">
        <a href="{{ route('daftarAlatKaryawan') }}"
           data-page="riwayat"
           class="tab-link {{ request()->routeIs('daftarAlatKaryawan') ? 'active' : '' }} 
                  px-6 py-3 rounded-full transition-all duration-300 font-semibold 
                  {{ request()->routeIs('daftarAlatKaryawan') ? 'text-white' : 'text-white/60' }} 
                  flex items-center gap-2 min-w-max">
            <i class="fa-solid fa-briefcase text-lg"></i>
            <span>Koleksi</span>
        </a>
        
        <a href="{{ route('riwayatPeminjamanKaryawan') }}"
           data-page="koleksi"
           class="tab-link {{ request()->routeIs('riwayatPeminjamanKaryawan') ? 'active' : '' }} 
                  px-6 py-3 rounded-full transition-all duration-300 font-semibold 
                  {{ request()->routeIs('riwayatPeminjamanKaryawan') ? 'text-white' : 'text-white/60' }} 
                  flex items-center gap-2 min-w-max">
            <i class="fa-solid fa-boxes text-lg"></i>
            <span>Riwayat</span>
        </a>
    </div>
</div>

<style>
    /* Pastikan fixed positioning benar */
    .fixed {
        position: fixed !important;
    }
    
    .tab-link.active {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        transform: scale(1.02);
    }
    
    .tab-link:not(.active) {
        background: transparent;
    }
    
    .tab-link:not(.active):hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.tab-link');
        const contentContainer = document.querySelector('main');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const url = this.href;
                const page = this.getAttribute('data-page');
                
                links.forEach(l => {
                    l.classList.remove('active', 'text-white');
                    l.classList.add('text-white/60');
                });
                this.classList.add('active', 'text-white');
                this.classList.remove('text-white/60');
                
                contentContainer.style.opacity = '0';
                contentContainer.style.transform = 'translateY(10px)';
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('main').innerHTML;
                    setTimeout(() => {
                        contentContainer.innerHTML = newContent;
                        contentContainer.style.opacity = '1';
                        contentContainer.style.transform = 'translateY(0)';
                        history.pushState({page: page}, '', url);
                    }, 300);
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = url;
                });
            });
        });
        
        window.addEventListener('popstate', function(e) {
            location.reload();
        });
    });
</script>