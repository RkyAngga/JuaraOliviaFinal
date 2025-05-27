@extends('Dashboardstlhlogin.Dinas.DasboardDinas')
@section('title', 'Statistik Dinas')

@section('Laporan')
<section class="min-h-screen pt-0">
    <div class="container mx-auto px-4 sm:px-8 pt-0 pb-4">

        <!-- Main Content Section -->
        <div class="bg-white rounded-xl shadow-xl pt-0 px-6 sm:px-8 pb-6 sm:pb-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0 mt-[-4rem]">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-800">Statistik Penyelesaian Pengaduan Dinas Tahun 2025</h3>
                </div>
            </div>

            <!-- Table dan Chart Container dengan Grid Responsif -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6 lg:gap-8">
                <!-- Table Container -->
                <div class="w-full overflow-x-auto bg-white p-4 rounded-lg shadow-sm">
                    <div class="min-w-full overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Dinas</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grade</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($dinasList as $dinas)
                                    @php
                                        // Hitung Grade berdasarkan poin dinas
                                        $grade = 'E'; // Default
                                        if ($dinas->point >= 90) $grade = 'A';
                                        elseif ($dinas->point >= 80) $grade = 'B';
                                        elseif ($dinas->point >= 70) $grade = 'C';
                                        elseif ($dinas->point >= 60) $grade = 'D';
                                        // Presentase langsung dari poin, maksimal 100%
                                        $percentage = min(100, $dinas->point);

                                        // Tentukan warna teks berdasarkan poin
                                        $textColorClass = 'text-gray-900'; // Default
                                        if ($dinas->point >= 199) $textColorClass = 'text-[#FEC23E]'; // >= 199 poin
                                        elseif ($dinas->point >= 101) $textColorClass = 'text-[#EBDDCF]'; // 101 - 198 poin
                                        elseif ($dinas->point >= 0) $textColorClass = 'text-[#FF8000]'; // 0 - 100 poin
                                        // Catatan: Kelas Tailwind CSS arbitrer (#...) mungkin perlu dikonfigurasi di tailwind.config.js
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6 font-medium {{ $textColorClass }}">{{ $dinas->username }}</td>
                                        <td class="py-4 px-6 text-gray-600">{{ $grade }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2.5 max-w-xs">
                                                    <div class="bg-yellow-500 h-2.5 rounded-full transition-all duration-500"
                                                         style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-700">{{ $percentage }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

              <!-- Chart Container dengan Responsif Height -->
              <div class="w-full bg-white p-4 rounded-lg shadow-sm min-h-[300px] md:min-h-[400px] flex flex-col">
                    <div class="flex-grow relative">
                        <canvas id="statistikChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                @push('scripts')
                <script src="{{ asset('js/chart.js/chart.umd.min.js') }}"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('statistikChart').getContext('2d');
                        
                        const chartConfig = {
                            type: 'doughnut',
                            data: {
                               labels: ['Di Tolak', 'Selesai', 'Di Proses'],
                                datasets: [{
                                    data: [{{ $ditolakCount ?? 0 }}, {{ $selesaiCount ?? 0 }}, {{ $prosesCount ?? 0 }}],
                                    backgroundColor: [
                                        '#FF0000',  // merah
                                        '#00FF00',  // hijau
                                        '#74B3FF'   // biru
                                    ],
                                    borderWidth: 0,
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: window.innerWidth < 768 ? 10 : 12,
                                            padding: window.innerWidth < 768 ? 10 : 20,
                                            font: {
                                                size: window.innerWidth < 768 ? 10 : 12
                                            }
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Statistik Daerah',
                                        font: {
                                            size: window.innerWidth < 768 ? 14 : 16,
                                            weight: 'bold'
                                        },
                                        padding: {
                                            bottom: window.innerWidth < 768 ? 5 : 10
                                        }
                                    },
                                    subtitle: {
                                        display: true,
                                        text: 'Persentase per Kecamatan',
                                        font: {
                                            size: window.innerWidth < 768 ? 12 : 14
                                        },
                                        padding: {
                                            bottom: window.innerWidth < 768 ? 10 : 20
                                        }
                                    }
                                },
                                cutout: '60%',
                                layout: {
                                    padding: {
                                        top: window.innerWidth < 768 ? 5 : 10,
                                        bottom: window.innerWidth < 768 ? 5 : 10
                                    }
                                }
                            }
                        };
                        
                        const chart = new Chart(ctx, chartConfig);
                        
                        // Resize handler untuk responsivitas
                        window.addEventListener('resize', function() {
                            chart.options.plugins.legend.labels.boxWidth = window.innerWidth < 768 ? 10 : 12;
                            chart.options.plugins.legend.labels.padding = window.innerWidth < 768 ? 10 : 20;
                            chart.options.plugins.legend.labels.font.size = window.innerWidth < 768 ? 10 : 12;
                            chart.options.plugins.title.font.size = window.innerWidth < 768 ? 14 : 16;
                            chart.options.plugins.subtitle.font.size = window.innerWidth < 768 ? 12 : 14;
                            chart.update();
                        });
                    });
                </script>
                @endpush
            </div>

            <!-- Chart JS Script dengan Konfigurasi Responsif -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('statistikChart').getContext('2d');
                    
                    const chartConfig = {
                        type: 'doughnut',
                        data: {
                           labels: ['Di Tolak', 'Selesai', 'Di Proses'],
                                datasets: [{
                                    data: [{{ $ditolakCount ?? 0 }}, {{ $selesaiCount ?? 0 }}, {{ $prosesCount ?? 0 }}],
                                    backgroundColor: [
                                        '#FF0000',  // merah
                                        '#00FF00',  // hijau
                                        '#74B3FF'   // biru
                                    ],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: window.innerWidth < 768 ? 10 : 12,
                                        padding: window.innerWidth < 768 ? 10 : 20,
                                        font: {
                                            size: window.innerWidth < 768 ? 10 : 12
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Statistik Daerah',
                                    font: {
                                        size: window.innerWidth < 768 ? 14 : 16,
                                        weight: 'bold'
                                    },
                                    padding: {
                                        bottom: window.innerWidth < 768 ? 5 : 10
                                    }
                                },
                                subtitle: {
                                    display: true,
                                    text: 'Persentase per Kecamatan',
                                    font: {
                                        size: window.innerWidth < 768 ? 12 : 14
                                    },
                                    padding: {
                                        bottom: window.innerWidth < 768 ? 10 : 20
                                    }
                                }
                            },
                            cutout: '60%',
                            layout: {
                                padding: {
                                    top: window.innerWidth < 768 ? 5 : 10,
                                    bottom: window.innerWidth < 768 ? 5 : 10
                                }
                            }
                        }
                    };

                    const chart = new Chart(ctx, chartConfig);

                    // Resize handler untuk responsivitas
                    window.addEventListener('resize', function() {
                        chart.options.plugins.legend.labels.boxWidth = window.innerWidth < 768 ? 10 : 12;
                        chart.options.plugins.legend.labels.padding = window.innerWidth < 768 ? 10 : 20;
                        chart.options.plugins.legend.labels.font.size = window.innerWidth < 768 ? 10 : 12;
                        chart.options.plugins.title.font.size = window.innerWidth < 768 ? 14 : 16;
                        chart.options.plugins.subtitle.font.size = window.innerWidth < 768 ? 12 : 14;
                        chart.update();
                    });
                });
            </script>
            </div>
        </div>
    </div>
</section>

@endsection