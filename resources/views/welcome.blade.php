<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KASIO - POS Retail Indonesia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-white dark:bg-slate-900 text-black dark:text-white">
    
    {{-- HEADER --}}
    <nav class="fixed w-full z-50 border-b border-slate-200 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-6">
        <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-black dark:bg-white rounded-lg flex items-center justify-center">
                    <span class="text-lg font-bold text-white dark:text-black">K</span>
                </div>
                <h1 class="text-xl font-semibold">KASIO</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-slate-600 dark:hover:text-slate-300">Masuk</a>
                <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-semibold bg-black dark:bg-white text-white dark:text-black rounded-lg hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">Daftar Gratis</a>
            </div>
        </div>
    </nav>

    {{-- HERO FULL BLEED --}}
    <section class="pt-32 pb-24 bg-gradient-to-r from-slate-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[0.9] mb-6">
                        POS <span class="text-black dark:text-white">Tercepat</span>
                    </h1>
                    <p class="text-xl text-slate-600 dark:text-slate-400 mb-8 max-w-lg leading-relaxed">
                        Kelola stok, transaksi, dan laporan penjualan dalam satu aplikasi ringan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-black dark:bg-white text-white dark:text-black font-semibold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">🚀 Mulai Gratis</a>
                        <a href="#demo" class="px-8 py-4 border border-slate-300 dark:border-slate-600 font-semibold rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Lihat Demo</a>
                    </div>
                </div>
                <div>
                    <div class="w-full h-96 bg-gradient-to-br from-slate-100 via-white to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-3xl shadow-2xl relative overflow-hidden border border-slate-200/50 dark:border-slate-700/50">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&auto=format&fit=crop" 
                             alt="KASIO POS Dashboard" 
                             class="w-full h-full rounded-3xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-transparent to-purple-500/10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR FULL WIDTH --}}
    <section class="py-24 px-6 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Fitur Utama</h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">Semua yang kamu butuh untuk toko lancar.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-10 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-3xl border border-slate-200/50 dark:border-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-black dark:bg-white rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white dark:text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L17.09 19l-1.95-1.95a7 7 0 01-9.9-9.9zm7 7a5 5 0 11-7.07-7.07 5 5 0 017.07 7.07z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Cari Cepat</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Barcode scanner 0.1 detik</p>
                </div>
                <div class="text-center p-10 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-3xl border border-slate-200/50 dark:border-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-black dark:bg-white rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white dark:text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Checkout Cepat</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">3x lebih cepat dari manual</p>
                </div>
                <div class="text-center p-10 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-3xl border border-slate-200/50 dark:border-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-black dark:bg-white rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white dark:text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Stok Real-time</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Update otomatis tiap transaksi</p>
                </div>
                <div class="text-center p-10 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-3xl border border-slate-200/50 dark:border-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-black dark:bg-white rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white dark:text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Laporan Lengkap</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Penjualan & keuntungan harian</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING FULL BLEED - BUTTON CENTERED --}}
    <section id="harga" class="py-24 px-6 bg-gradient-to-r from-slate-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Pilih Paket</h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">Mulai gratis, upgrade kapan saja.</p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-10 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-2xl hover:border-slate-300 transition-all text-center">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black mb-4">FREE</h3>
                        <div class="text-4xl font-black text-slate-900 dark:text-white mb-1">Rp 0</div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">selamanya</p>
                    </div>
                    <ul class="space-y-3 mb-10 text-sm text-slate-600 dark:text-slate-400 text-left mx-auto max-w-xs">
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>50 Produk</li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>Transaksi unlimited</li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>Stok dasar</li>
                    </ul>
                    <div class="mx-auto w-fit">
                        <a href="{{ route('register') }}" class="block bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-4 px-8 rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all mx-auto">Mulai Gratis</a>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-10 border-2 border-slate-200/50 dark:border-slate-600/50 hover:shadow-2xl hover:border-slate-400 transition-all text-center">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black mb-4">BASIC</h3>
                        <div class="text-4xl font-black text-slate-900 dark:text-white mb-1">Rp 29.000</div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">/bulan</p>
                    </div>
                    <ul class="space-y-3 mb-10 text-sm text-slate-600 dark:text-slate-400 text-left mx-auto max-w-xs">
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>500 Produk</li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>2 Pengguna</li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span>Laporan mingguan</li>
                    </ul>
                    <div class="mx-auto w-fit">
                        <a href="{{ route('register') }}" class="block bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 font-semibold py-4 px-8 rounded-2xl text-lg hover:bg-slate-800 dark:hover:bg-slate-200 transition-all mx-auto">Pilih BASIC</a>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-10 border-2 border-slate-900/50 dark:border-white/50 hover:shadow-2xl hover:border-slate-700 transition-all text-center">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black mb-4">PREMIUM</h3>
                        <div class="text-4xl font-black text-slate-900 dark:text-white mb-1">Rp 79.000</div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">/bulan</p>
                    </div>
                    <ul class="space-y-3 mb-10 text-sm text-slate-600 dark:text-slate-400 text-left mx-auto max-w-xs">
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span><strong>Unlimited Produk</strong></li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span><strong>Unlimited Pengguna</strong></li>
                        <li class="flex items-center"><span class="w-5 h-5 bg-emerald-500 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold">✓</span><strong>Priority Support</strong></li>
                    </ul>
                    <div class="mx-auto w-fit">
                        <a href="{{ route('register') }}" class="block bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold py-4 px-8 rounded-2xl text-lg hover:bg-slate-800 dark:hover:bg-slate-200 transition-all mx-auto">Pilih PREMIUM</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER FULL WIDTH --}}
    <footer class="border-t border-slate-200 dark:border-slate-800 py-16 px-6 bg-slate-950 dark:bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center space-x-3 mb-8">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-2xl font-bold text-black">K</span>
                </div>
                <h3 class="text-2xl font-semibold">KASIO</h3>
            </div>
            <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">
                POS tercepat untuk UMKM Indonesia.
            </p>
            <div class="flex flex-wrap gap-8 justify-center text-sm text-slate-400 mb-12">
                <a href="{{ route('login') }}" class="hover:text-white transition-colors px-4 py-2 hover:bg-white/10 rounded-xl">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors px-4 py-2 hover:bg-white/10 rounded-xl">Daftar Gratis</a>
                <a href="mailto:hello@kasio.id" class="hover:text-white transition-colors px-4 py-2 hover:bg-white/10 rounded-xl">hello@kasio.id</a>
            </div>
            <div class="text-xs text-slate-500">
                © 2025 KASIO. Surabaya, Indonesia.
            </div>
        </div>
    </footer>

</body>
</html>
