<div class="space-y-6">
    {{-- HEADER HALAMAN (Judul & Tombol) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Sales History
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage and view your transaction history.
            </p>
        </div>

        {{-- LOGIC TOMBOL EXPORT --}}
        <div>
            @if(auth()->user()->canExportReport())
                {{-- JIKA MEMBER PREMIUM (TOMBOL AKTIF) --}}
                <button wire:click="downloadPdf" wire:loading.attr="disabled"
                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-wait">
                    
                    <svg wire:loading wire:target="downloadPdf" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <svg wire:loading.remove wire:target="downloadPdf" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    
                    <span>Export Report</span>
                </button>
            @else
                {{-- MEMBER FREE (TOMBOL LOCKED) --}}
                <button type="button" onclick="alert('Fitur ini khusus Premium Member! Silakan upgrade membership Anda.')"
                    class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 text-gray-400 font-medium px-4 py-2 rounded-lg cursor-not-allowed border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    
                    {{-- Icon Gembok --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <span>Export Locked</span>
                </button>
            @endif
        </div>
    </div>

    {{-- TABEL FILAMENT --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        {{ $this->table }}
    </div>
</div>