<div>
    @php
        $user = auth()->user();
        $currentMembership = $user->effective_membership;
        $userMembership = $user->activeMembership;

        $membershipName = $currentMembership?->name ?? 'Free';

        $productLimit  = $currentMembership?->product_limit;
        $customerLimit = $currentMembership?->customer_limit;
        $posLimit      = $currentMembership?->daily_pos_limit;

        $badgeClass = match($membershipName) {
            'Premium' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
            'Basic'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            default   => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
        };
    @endphp

    {{-- KARTU STATUS MEMBERSHIP --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-gray-200 dark:border-neutral-700 p-6 mb-8">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Membership Aktif
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                        {{ $membershipName }}
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    {{-- PRODUK --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Produk</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $user->productCount() }}
                            /
                            @if(is_null($productLimit))
                                <span class="text-green-500">∞</span>
                            @else
                                {{ $productLimit }}
                            @endif
                        </p>
                    </div>

                    {{-- PELANGGAN --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Pelanggan</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $user->customerCount() }}
                            /
                            @if(is_null($customerLimit))
                                <span class="text-green-500">∞</span>
                            @else
                                {{ $customerLimit }}
                            @endif
                        </p>
                    </div>

                    {{-- POS HARI INI --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">POS Hari Ini</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $user->todayPosCount() }}
                            /
                            @if(is_null($posLimit))
                                <span class="text-green-500">∞</span>
                            @else
                                {{ $posLimit }}
                            @endif
                        </p>
                    </div>

                    {{-- EXPIRED --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Expired</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $userMembership?->ends_at ? $userMembership->ends_at->format('d M Y') : 'Selamanya' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HEADER PILIH PAKET --}}
    <div class="mb-8" id="paket">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            Pilih Paket Membership
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Tingkatkan bisnis Anda dengan paket yang sesuai
        </p>
    </div>

    {{-- KARTU PAKET MEMBERSHIP --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($memberships as $membership)
            <div
                class="bg-white dark:bg-neutral-800 rounded-xl border border-gray-200 dark:border-neutral-700 p-6 hover:border-gray-300 dark:hover:border-neutral-600 transition-colors">

                {{-- HEADER PAKET --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                        {{ $membership['name'] }}
                    </h3>   
                    <div class="flex items-baseline gap-1">
                        <span class="text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($membership['price'], 0, ',', '.') }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">/ tahun</span>
                    </div>
                </div>

                {{-- FITUR --}}
                <ul class="space-y-3 mb-6">
                    @foreach ($membership['features'] as $feature)
                        <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd" />
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                {{-- TOMBOL PILIH --}}
                <button
                    wire:click="selectMembership('{{ $membership['name'] }}')"
                    class="w-full py-2.5 rounded-lg font-medium transition-colors
                        {{ $membership['name'] === 'Premium'
                            ? 'bg-indigo-600 hover:bg-indigo-700 text-white'
                            : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white' }}">
                    Pilih Paket
                </button>
            </div>
        @endforeach
    </div>
</div>
