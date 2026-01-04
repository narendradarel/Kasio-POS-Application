<div class="p-6 space-y-6">
    
    {{-- SECTION 1: GRAFIK PENGUNJUNG --}}
    <div class="bg-white p-4 rounded-lg shadow sm:p-6 dark:bg-gray-800">
        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">
            Statistik Pengunjung (7 Hari Terakhir)
        </h3>
        <div id="visitorChart" class="w-full h-64"></div>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama / Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan Saat Ini</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Subskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                    {{ $user->initials() }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- Menggunakan Helper membershipName() dari Model User Anda --}}
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->membershipName() == 'Free' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->membershipName() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                             @if($user->activeMembership)
                                <span class="text-green-600 font-bold">Active</span>
                                <br>
                                <span class="text-xs">
                                    s.d {{ $user->activeMembership->ends_at ? \Carbon\Carbon::parse($user->activeMembership->ends_at)->format('d M Y') : 'Selamanya' }}
                                </span>
                             @else
                                <span class="text-gray-500">Free Tier</span>
                             @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK APEXCHARTS --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        var options = {
            series: [{
                name: 'Pengunjung',
                data: @json($chartCounts)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: {
                categories: @json($chartDates),
                type: 'datetime'
            },
            tooltip: {
                x: { format: 'dd MMM yyyy' }
            },
            colors: ['#4F46E5'] // Indigo color
        };

        var chart = new ApexCharts(document.querySelector("#visitorChart"), options);
        chart.render();
    });
</script>