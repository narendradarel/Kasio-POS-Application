<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KASIO - Teman Jualan Kamu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Font Inter agar terlihat modern di HP & Desktop --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Hide scrollbar for horizontal scroll areas */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased bg-white text-slate-900 selection:bg-indigo-100 selection:text-indigo-900">

    {{-- NAVBAR RESPONSIVE --}}
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between">
            
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 z-50">
                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-lg sm:text-xl">K</div>
                <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900">KASIO</span>
            </a>

            {{-- Desktop Menu (Hidden on Mobile) --}}
            <div class="hidden md:flex items-center gap-6 lg:gap-8">
                <a href="#cerita" class="text-sm font-medium text-slate-600 hover:text-slate-900">Kenapa Kasio?</a>
                <a href="#harga" class="text-sm font-medium text-slate-600 hover:text-slate-900">Harga</a>
                <div class="h-6 w-px bg-slate-200"></div>
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-900 hover:text-indigo-600">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-full hover:bg-slate-800 transition-all hover:scale-105">
                    Daftar Gratis
                </a>
            </div>

            {{-- Mobile Hamburger Button --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600 focus:outline-none z-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu Overlay (Hidden by default) --}}
        <div id="mobile-menu" class="fixed inset-0 bg-white z-40 flex flex-col items-center justify-center gap-8 opacity-0 pointer-events-none transition-all duration-300">
            <a href="#cerita" class="text-xl font-medium text-slate-900 mobile-link">Kenapa Kasio?</a>
            <a href="#harga" class="text-xl font-medium text-slate-900 mobile-link">Harga Paket</a>
            <a href="{{ route('login') }}" class="text-xl font-medium text-slate-900 mobile-link">Masuk Akun</a>
            <a href="{{ route('register') }}" class="px-8 py-3 bg-slate-900 text-white text-lg font-semibold rounded-full shadow-xl mobile-link">
                Daftar Gratis Sekarang
            </a>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <header class="pt-28 pb-16 sm:pt-40 sm:pb-24 lg:pt-48 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                
                {{-- Text Content --}}
                <div class="w-full lg:w-1/2 text-center lg:text-left order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-6 border border-indigo-100">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Notes: Aplikasi dalam tahap pengembangan
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                        Ngurus Kasir<br class="hidden sm:block">
                        harus buat laporan juga <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Ribet?</span>
                    </h1>
                    
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
                        KASIO bantu kamu pantau stok, dan cetak laporan dari HP. Gak perlu laptop mahal, yang penting jualan lancar.
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            Cobain Gratis Dulu
                        </a>
                        <a href="#demo" class="inline-flex justify-center items-center px-8 py-4 bg-white text-slate-700 border border-slate-200 font-semibold rounded-xl hover:bg-slate-50 transition-all">
                            Lihat Videonya
                        </a>
                    </div>
                    
                    <p class="mt-4 text-xs text-slate-400">
                        *Tanpa kartu kredit. Bisa cancel kapan aja.
                    </p>
                </div>

                {{-- Image Visual --}}
                <div class="w-full lg:w-1/2 relative order-1 lg:order-2 px-4 sm:px-0">
                    <div class="absolute -top-10 -right-10 w-40 h-40 sm:w-72 sm:h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 sm:w-72 sm:h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                    
                    {{-- Dashboard Mockup --}}
                    <div class="relative rounded-2xl sm:rounded-3xl bg-slate-900 p-2 sm:p-3 shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80" alt="App Dashboard" class="rounded-xl sm:rounded-2xl border border-slate-800 shadow-inner w-full h-auto object-cover aspect-[4/3]">
                        
                        {{-- Floating Badge (Hidden on very small screens) --}}
                        <div class="hidden sm:flex absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl border border-slate-100 items-center gap-3 animate-bounce-slow">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 font-medium">Omzet Hari Ini</div>
                                <div class="text-lg font-bold text-slate-900">Rp 1.250.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- STORYTELLING FEATURES --}}
    <section id="cerita" class="py-16 sm:py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-24">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Gak Cuma Mesin Kasir</h2>
                <p class="text-base sm:text-lg text-slate-600">KASIO ngerti banget pusingnya ngurus toko sendirian. Kami bantuin hal-hal kecil yang bikin capek.</p>
            </div>

            <div class="space-y-20 sm:space-y-32">
                {{-- Feature 1: Mobile Stacked, Desktop Row --}}
                <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
                    <div class="w-full md:w-1/2 bg-orange-50 rounded-3xl p-8 sm:p-12 relative overflow-hidden group">
                         <div class="absolute top-0 right-0 w-32 h-32 bg-orange-100 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" class="relative z-10 w-full drop-shadow-lg mix-blend-multiply" alt="Stock Illustration">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">"Yah, barangnya habis kak..."</h3>
                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-6">
                            Jangan sampai nolak pembeli cuma gara-gara lupa cek gudang. Di KASIO, stok otomatis berkurang tiap ada transaksi. Ada notifikasi kalau barang mau habis.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-slate-700 text-sm sm:text-base">
                                <span class="text-green-500 font-bold">✓</span> Peringatan stok menipis
                            </li>
                            <li class="flex items-center gap-3 text-slate-700 text-sm sm:text-base">
                                <span class="text-green-500 font-bold">✓</span> Cek stok dari HP di rumah
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Feature 2: Mobile Stacked, Desktop Row Reverse --}}
                <div class="flex flex-col md:flex-row-reverse items-center gap-10 md:gap-16">
                    <div class="w-full md:w-1/2 bg-blue-50 rounded-3xl p-8 sm:p-12 relative overflow-hidden group">
                         <div class="absolute top-0 left-0 w-32 h-32 bg-blue-100 rounded-full -ml-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/business-analysis-4537604-3796517.png" class="relative z-10 w-full drop-shadow-lg mix-blend-multiply" alt="Report Illustration">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Malam Minggu Masih Rekap Nota?</h3>
                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-6">
                            Disini sudah bisa cetak laporan penjualan.
                         <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-slate-700 text-sm sm:text-base">
                                <span class="text-green-500 font-bold">✓</span> Laporan Penjualan Harian
                            </li>
                            <li class="flex items-center gap-3 text-slate-700 text-sm sm:text-base">
                                <span class="text-green-500 font-bold">✓</span> Download Laporan Excel
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING RESPONSIVE --}}
    <section id="harga" class="py-20 sm:py-32 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Pilih Sesuai Kantong</h2>
                <p class="text-slate-600">Investasi ringan buat untung maksimal. Bisa ganti paket kapan aja.</p>
            </div>

            {{-- Grid 1 Col on Mobile, 3 Col on Desktop --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 max-w-6xl mx-auto items-start">
                
                {{-- FREE --}}
                <div class="order-2 lg:order-1 bg-white border border-slate-200 rounded-3xl p-8 hover:border-slate-300 transition-all shadow-sm">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Free</h3>
                    <p class="text-sm text-slate-500 mb-6">Buat yang baru coba-coba.</p>
                    <div class="text-4xl font-extrabold text-slate-900 mb-6">Rp 0</div>
                    <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-slate-100 text-slate-900 font-semibold rounded-xl text-center hover:bg-slate-200 transition-all mb-8">Daftar Gratis</a>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> 50 Produk</li>
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> Cobain fitur transaksi</li>
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> Laporan Penjualan</li>
                    </ul>
                </div>

                {{-- POPULAR (Juragan) --}}
                <div class="order-1 lg:order-2 bg-slate-900 text-white rounded-3xl p-8 lg:p-10 shadow-2xl transform lg:-translate-y-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">PALING LARIS</div>
                    <h3 class="font-bold text-xl mb-2">Basic</h3>
                    <p class="text-sm text-slate-400 mb-6">Toko mulai rame pembeli.</p>
                    <div class="flex items-end gap-1 mb-6">
                        <div class="text-5xl font-extrabold">Rp 50rb</div>
                        <span class="text-slate-400 mb-2">/tahun</span>
                    </div>
                    <a href="{{ route('register') }}" class="block w-full py-4 px-6 bg-white text-slate-900 font-bold rounded-xl text-center hover:bg-indigo-50 transition-all mb-8 shadow-lg">Pilih Paket Basic</a>
                    <ul class="space-y-4 text-sm text-slate-300">
                        <li class="flex items-center gap-3"><span class="text-green-400 font-bold">✓</span> 500 Produk</li>
                        <li class="flex items-center gap-3"><span class="text-green-400 font-bold">✓</span> Fitur transaksi 100 kali</li>
                        <li class="flex items-center gap-3"><span class="text-green-400 font-bold">✓</span> Bisa Cetak Laporan Penjualan</li>
                    </ul>
                </div>

                {{-- PREMIUM --}}
                <div class="order-3 bg-white border border-slate-200 rounded-3xl p-8 hover:border-slate-300 transition-all shadow-sm">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Premium</h3>
                    <p class="text-sm text-slate-500 mb-6">Buat yang punya uang lebih.</p>
                    <div class="flex items-end gap-1 mb-6">
                        <div class="text-4xl font-extrabold text-slate-900">Rp 100rb</div>
                        <span class="text-slate-500 mb-1">/tahun</span>
                    </div>
                    <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-indigo-50 text-indigo-700 font-semibold rounded-xl text-center hover:bg-indigo-100 transition-all mb-8">Pilih Paket Premium</a>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> Unlimited Produk</li>
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> Fitur transaksi unlimited</li>
                        <li class="flex items-center gap-3"><span class="text-green-500 font-bold">✓</span> Bisa Cetak Laporan Penjualan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA MOBILE FRIENDLY --}}
    <section class="py-16 sm:py-24 px-4">
        <div class="max-w-5xl mx-auto bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2rem] p-8 sm:p-16 text-center relative overflow-hidden shadow-2xl">
            {{-- Decorative pattern --}}
            <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <h2 class="text-2xl sm:text-4xl font-bold text-white mb-4 sm:mb-6 relative z-10">Yuk, Rapikan Toko Sekarang!</h2>
            <p class="text-slate-300 mb-8 max-w-xl mx-auto text-base sm:text-lg relative z-10 leading-relaxed">Jangan nunggu toko berantakan dulu baru sadar butuh sistem. Daftar gratis, cobain fiturnya sepuasnya.</p>
            
            <a href="{{ route('register') }}" class="inline-block w-full sm:w-auto px-8 py-4 bg-white text-slate-900 font-bold rounded-full text-lg hover:bg-indigo-50 hover:scale-105 transition-all relative z-10 shadow-xl">
                Daftar KASIO Gratis
            </a>
            <p class="mt-6 text-xs sm:text-sm text-slate-500 relative z-10">Proses daftar cuma 1 menit.</p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white pt-16 pb-8 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12 mb-12">
                <div class="col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center font-bold">K</div>
                        <span class="font-bold text-lg text-slate-900">KASIO</span>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Aplikasi kasir asli Surabaya untuk memajukan UMKM Indonesia.
                    </p>
                </div>
                
                {{-- Links --}}
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Produk</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-indigo-600">Fitur Kasir</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Laporan</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Membership</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-indigo-600">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Tutorial</a></li>
                        <li><a href="#" class="hover:text-indigo-600">Kontak WA</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                <p class="text-xs text-slate-400">© 2025 PT KASIO </p>
                <div class="flex gap-4">
                   </div>
            </div>
        </div>
    </footer>
    
    {{-- JAVASCRIPT UNTUK MOBILE MENU --}}
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const links = document.querySelectorAll('.mobile-link');
        let isMenuOpen = false;

        btn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if (isMenuOpen) {
                // Open Menu
                menu.classList.remove('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'hidden'; // Disable scroll
            } else {
                // Close Menu
                menu.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'auto'; // Enable scroll
            }
        });

        // Close menu when a link is clicked
        links.forEach(link => {
            link.addEventListener('click', () => {
                isMenuOpen = false;
                menu.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'auto';
            });
        });

        // Add shadow to navbar on scroll
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
             if (window.scrollY > 10) {
                 nav.classList.add('shadow-md');
             } else {
                 nav.classList.remove('shadow-md');
             }
        });
    </script>
</body>
</html>