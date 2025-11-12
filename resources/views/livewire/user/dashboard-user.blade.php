@section('title', 'Dashboard')

@push('css')
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stats-icon i {
        font-size: 1.25rem;
        color: #fff;
    }
    .stats-icon.purple { background: linear-gradient(310deg, #627594, #A8B8D8); }
    .stats-icon.red { background: linear-gradient(310deg, #ea0606, #ff667c); }
    .stats-icon.blue { background: linear-gradient(310deg, #2152ff, #21d4fd); }
    .stats-icon.green { background: linear-gradient(310deg, #17ad37, #98ec2d); }
</style>
@endpush

<div>
    <div class="page-heading mb-4">
        <h3 class="font-bold text-2xl text-gray-800">Dashboard</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <!-- Statistik Cards -->
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-xs border">
                            <div class="card-body px-4 py-4">
                                <div class="row align-items-center">
                                    <div class="col-5 col-xl-12">
                                        <div class="stats-icon purple mb-3">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-xl-12 text-start text-xl-center mt-xl-3">
                                        <h6 class="text-muted text-sm font-weight-bold mb-1">Total Laporan</h6>
                                        <h5 class="font-weight-bolder mb-0">{{ $totalLaporan }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-xs border">
                            <div class="card-body px-4 py-4">
                                <div class="row align-items-center">
                                    <div class="col-5 col-xl-12">
                                        <div class="stats-icon red mb-3">
                                            <i class="fas fa-hourglass-half" style="animation: spin 3s linear infinite;"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-xl-12 text-start text-xl-center mt-xl-3">
                                        <h6 class="text-muted text-sm font-weight-bold mb-1">Menunggu</h6>
                                        <h5 class="font-weight-bolder mb-0">{{ $laporanPending }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-xs border">
                            <div class="card-body px-4 py-4">
                                <div class="row align-items-center">
                                    <div class="col-5 col-xl-12">
                                        <div class="stats-icon blue mb-3">
                                            <i class="fas fa-sync-alt" style="animation: spin 3s linear infinite;"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-xl-12 text-start text-xl-center mt-xl-3">
                                        <h6 class="text-muted text-sm font-weight-bold mb-1">Diproses</h6>
                                        <h5 class="font-weight-bolder mb-0">{{ $laporanProses }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-xs border">
                            <div class="card-body px-4 py-4">
                                <div class="row align-items-center">
                                    <div class="col-5 col-xl-12">
                                        <div class="stats-icon green mb-3">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-xl-12 text-start text-xl-center mt-xl-3">
                                        <h6 class="text-muted text-sm font-weight-bold mb-1">Selesai</h6>
                                        <h5 class="font-weight-bolder mb-0">{{ $laporanSelesai }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart: Laporan per Bulan -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm border">
                            <div class="card-header">
                                <h5 class="mb-0">Laporan per Bulan {{ now()->year }}</h5>
                            </div>
                            <div class="card-body">
                                <div id="grafik-laporan-bar" wire:ignore></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pie Chart + Ringkasan Keuangan -->
            <div class="col-12 col-lg-3">
                <!-- Pie Chart: Status -->
                <div class="card shadow-sm border mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Status Laporan</h5>
                    </div>
                    <div class="card-body">
                        <div id="grafik-laporan-pie" wire:ignore></div>
                    </div>
                </div>

                <!-- Ringkasan Keuangan -->
                <div class="card shadow-sm border">
                    <div class="card-header">
                        <h5 class="mb-0">Ringkasan Keuangan Anda</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                        <p><strong>Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>

<script>
    // Simpan instance chart agar bisa di-destroy
    window.ApexChartsInstances = window.ApexChartsInstances || {};

    function renderCharts() {
        const laporanPerBulan = @json($laporanPerBulan ?: []);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Bersihkan chart lama jika ada
        ['grafik-laporan-bar', 'grafik-laporan-pie'].forEach(id => {
            if (window.ApexChartsInstances[id]) {
                window.ApexChartsInstances[id].destroy();
                delete window.ApexChartsInstances[id];
            }
            const el = document.getElementById(id);
            if (el) el.innerHTML = '';
        });

        // Bar Chart
        const barEl = document.getElementById('grafik-laporan-bar');
        if (barEl) {
            const dataPerBulan = months.map((_, i) =>
                Number(laporanPerBulan[String(i + 1).padStart(2, '0')] || 0)
            );

            const barChart = new ApexCharts(barEl, {
                series: [{ name: 'Laporan', data: dataPerBulan }],
                chart: { type: 'bar', height: 320, toolbar: { show: false } },
                xaxis: { categories: months },
                colors: ['#2152ff'],
                plotOptions: { bar: { borderRadius: 6, dataLabels: { position: 'top' } } },
                dataLabels: { enabled: true, style: { fontSize: '11px' } }
            });
            barChart.render();
            window.ApexChartsInstances['grafik-laporan-bar'] = barChart;
        }

        // Pie Chart
        const pieEl = document.getElementById('grafik-laporan-pie');
        if (pieEl) {
            const series = [
                Number({{ $laporanPending ?? 0 }}),
                Number({{ $laporanProses ?? 0 }}),
                Number({{ $laporanSelesai ?? 0 }})
            ];

            const pieChart = new ApexCharts(pieEl, {
                series: series,
                labels: ['Menunggu', 'Diproses', 'Selesai'],
                colors: ['#ff667c', '#21d4fd', '#98ec2d'],
                chart: { type: 'pie', height: 300 },
                plotOptions: { pie: { donut: { size: '60%' } } },
                legend: { position: 'bottom', fontSize: '12px' },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { width: 200 }, legend: { position: 'bottom' } }
                }]
            });
            pieChart.render();
            window.ApexChartsInstances['grafik-laporan-pie'] = pieChart;
        }
    }

    // Gunakan Livewire hook yang lebih andal
    document.addEventListener('livewire:init', () => {
        if (typeof ApexCharts !== 'undefined') renderCharts();
    });

    document.addEventListener('livewire:navigated', () => {
        if (typeof ApexCharts !== 'undefined') renderCharts();
    });
</script>
@endpush
