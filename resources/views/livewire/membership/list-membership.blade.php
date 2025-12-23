<div>
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($memberships as $membership)
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">
                        {{ $membership['name'] }}
                    </h2>

                    <p class="text-3xl font-extrabold text-indigo-600 mb-4">
                        Rp {{ number_format($membership['price'], 0, ',', '.') }}
                        <span class="text-sm font-normal text-gray-500">/ tahun</span>
                    </p>

                    <ul class="flex-1 space-y-2 mb-6">
                        @foreach ($membership['features'] as $feature)
                            <li class="text-sm text-gray-600 dark:text-gray-300">
                                ✔ {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <button wire:click="selectMembership('{{ $membership['name'] }}')"
                        class="mt-auto w-full py-3 rounded-xl bg-indigo-600 text-white">
                        Pilih Paket
                    </button>

                </div>
            @endforeach
        </div>
        {{-- AKHIR GRID HARGA --}}

        <hr class="border-t border-gray-200 dark:border-neutral-700 mt-8 mb-4">

        <div class="py-16 flex flex-col">
            <div class="text-center w-full">
                {{-- Konten teks bisa diatur max-width di sini jika mau lebih sempit --}}

                <h3 class="text-3xl font-extrabold text-indigo-600 mb-2 sm:text-4xl dark:text-indigo-400">
                    Tingkatkan Penjualan Anda Hingga 50%
                </h3>

                <p class="text-xl text-gray-700 max-w-3xl mx-auto mb-6 dark:text-gray-300">
                    Dapatkan fitur manajemen inventori dan analisis penjualan canggih yang hanya tersedia di paket
                    **Premium**.
                </p>

            </div>
        </div>
        {{-- AKHIR BANNER --}}
    </div>
</div>