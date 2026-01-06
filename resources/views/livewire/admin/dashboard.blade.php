<div class="p-6 space-y-6">

    {{-- SECTION 1: STATISTIK PENGUNJUNG (Simple Bar Chart) --}}
    <div class="bg-white p-6 rounded-lg shadow dark:bg-gray-800">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
            Statistik Pengunjung (7 Hari Terakhir)
        </h3>
        
        <div class="space-y-4">
            @foreach($chartDates as $index => $date)
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}
                    </span>
                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $chartCounts[$index] ?? 0 }} pengunjung
                    </span>
                </div>
                
                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                    <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ ($chartCounts[$index] ?? 0) > 0 ? min(($chartCounts[$index] / max($chartCounts)) * 100, 100) : 0 }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Summary Total --}}
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <span class="text-base font-medium text-gray-700 dark:text-gray-300">
                    Total Pengunjung (7 Hari)
                </span>
                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ array_sum($chartCounts) }}
                </span>
            </div>
        </div>
    </div>

    {{-- SECTION 2: DAFTAR PENGGUNA --}}
    <div class="bg-white shadow rounded-lg dark:bg-gray-800 overflow-hidden">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Daftar Pengguna Terdaftar
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Nama / Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Plan Saat Ini
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Status Subskripsi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Bergabung
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $membershipColors = [
                                        'Free' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'Basic' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
                                        'Premium' => 'bg-indigo-600 text-white dark:bg-indigo-700'
                                    ];
                                    $colorClass = $membershipColors[$user->membershipName()] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                    {{ $user->membershipName() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($user->activeMembership)
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold">Active</span>
                                    <br>
                                    <span class="text-xs">
                                        s.d {{ $user->activeMembership->ends_at ? \Carbon\Carbon::parse($user->activeMembership->ends_at)->format('d M Y') : 'Selamanya' }}
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Free Tier</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
