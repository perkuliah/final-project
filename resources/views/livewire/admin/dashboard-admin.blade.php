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
    .stats-icon.orange { background: linear-gradient(310deg, #ff8c00, #ffa500); }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    .saldo-positif { color: #17ad37; font-weight: bold; }
    .saldo-negatif { color: #ea0606; font-weight: bold; }
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
                        <h5 class="mb-0">Ringkasan Keuangan</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                        <p><strong>Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                        <p><strong>Saldo:</strong>
                            <span class="{{ ($totalPemasukan - $totalPengeluaran) >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                                Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                            </span>
                        </p>
                        <p><strong>Jumlah Pelapor:</strong> {{ $jumlahPelapor }}</p>
                    </div>
                </div>
            </div>

            <!-- Grafik Pemasukan & Pengeluaran per Lokasi -->
            <div class="row mt-4">
                <!-- Pemasukan -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm border">
                        <div class="card-header">
                            <h5 class="mb-0">Pemasukan per Lokasi</h5>
                        </div>
                        <div class="card-body">
                            <div id="grafik-pemasukan-lokasi" wire:ignore></div>
                        </div>
                    </div>
                </div>

                <!-- Pengeluaran -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm border">
                        <div class="card-header">
                            <h5 class="mb-0">Pengeluaran per Lokasi</h5>
                        </div>
                        <div class="card-body">
                            <div id="grafik-pengeluaran-lokasi" wire:ignore></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart: Laporan per Pelapor -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border">
                        <div class="card-header">
                            <h5 class="mb-0">Laporan per Pelapor</h5>
                        </div>
                        <div class="card-body">
                            <div id="grafik-laporan-pelapor" wire:ignore></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL KEUANGAN PER PELAPOR - SECTION BARU -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border">
                        <div class="card-header">
                            <h5 class="mb-0">Detail Keuangan per Pelapor</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Pelapor</th>
                                            <th>Jumlah Laporan</th>
                                            <th>Total Pemasukan</th>
                                            <th>Total Pengeluaran</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($keuanganPerPelapor as $nama => $data)
                                            <tr>
                                                <td>{{ $nama }}</td>
                                                <td class="text-center">{{ $data['jumlah_laporan'] }}</td>
                                                <td class="text-end">Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                                                <td class="text-end {{ $data['saldo'] >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                                                    Rp {{ number_format($data['saldo'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data pelapor</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">{{ $totalLaporan }}</th>
                                            <th class="text-end">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                                            <th class="text-end">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                                            <th class="text-end {{ ($totalPemasukan - $totalPengeluaran) >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                                                Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0"></script>

<script>
    // Simpan referensi ke semua chart agar bisa di-destroy
    let activeCharts = [];

    function destroyAllCharts() {
        activeCharts.forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        activeCharts = [];
    }

    function renderCharts() {
        // Hancurkan chart lama dulu
        destroyAllCharts();

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const laporanPerBulan = @json($laporanPerBulan ?: []);

        // --- Grafik Laporan per Bulan ---
        const barTarget = document.querySelector("#grafik-laporan-bar");
        if (barTarget) {
            const dataPerBulan = months.map((m, i) => Number(laporanPerBulan[String(i + 1).padStart(2, '0')]) || 0);
            const chart = new ApexCharts(barTarget, {
                series: [{ name: 'Laporan', data: dataPerBulan }],
                chart: { type: 'bar', height: 320, toolbar: { show: false } },
                xaxis: { categories: months },
                colors: ['#2152ff'],
                plotOptions: { bar: { borderRadius: 6, dataLabels: { position: 'top' } } }
            });
            chart.render();
            activeCharts.push(chart);
        }

        // --- Pie Chart: Status ---
        const pieTarget = document.querySelector("#grafik-laporan-pie");
        if (pieTarget) {
            const series = [
                Number({{ $laporanPending ?? 0 }}),
                Number({{ $laporanProses ?? 0 }}),
                Number({{ $laporanSelesai ?? 0 }})
            ];
            const chart = new ApexCharts(pieTarget, {
                series: series,
                labels: ['Menunggu', 'Diproses', 'Selesai'],
                colors: ['#ff667c', '#21d4fd', '#98ec2d'],
                chart: { type: 'pie', height: 300 },
                plotOptions: { pie: { donut: { size: '60%' } } },
                legend: { position: 'bottom', fontSize: '12px' }
            });
            chart.render();
            activeCharts.push(chart);
        }

        // --- Pemasukan per Lokasi ---
        const pemasukanPerLokasi = @json($pemasukanPerLokasi ?: []);
        const lokasiLabels = @json(array_keys($pemasukanPerLokasi));

        const chartPemasukan = document.querySelector("#grafik-pemasukan-lokasi");
        if (chartPemasukan) {
            const valuesPemasukan = lokasiLabels.map(loc => Number(pemasukanPerLokasi[loc]) || 0);
            const chart = new ApexCharts(chartPemasukan, {
                series: [{ name: 'Pemasukan', data: valuesPemasukan }],
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                xaxis: { categories: lokasiLabels },
                colors: ['#21d4fd'],
                plotOptions: { bar: { borderRadius: 6 } },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
                        }
                    }
                }
            });
            chart.render();
            activeCharts.push(chart);
        }

        // --- Pengeluaran per Lokasi ---
        const pengeluaranPerLokasi = @json($pengeluaranPerLokasi ?: []);
        const chartPengeluaran = document.querySelector("#grafik-pengeluaran-lokasi");
        if (chartPengeluaran) {
            const valuesPengeluaran = lokasiLabels.map(loc => Number(pengeluaranPerLokasi[loc]) || 0);
            const chart = new ApexCharts(chartPengeluaran, {
                series: [{ name: 'Pengeluaran', data: valuesPengeluaran }],
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                xaxis: { categories: lokasiLabels },
                colors: ['#ff667c'],
                plotOptions: { bar: { borderRadius: 6 } },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
                        }
                    }
                }
            });
            chart.render();
            activeCharts.push(chart);
        }

        // --- Laporan per Pelapor ---
        const laporanPerPelapor = @json($laporanPerPelapor ?: []);
        const pelaporLabels = Object.keys(laporanPerPelapor);
        const pelaporValues = Object.values(laporanPerPelapor).map(Number);

        const chartPelapor = document.querySelector("#grafik-laporan-pelapor");
        if (chartPelapor && pelaporLabels.length > 0) {
            const chart = new ApexCharts(chartPelapor, {
                series: [{ name: 'Jumlah Laporan', data: pelaporValues }],
                chart: { type: 'bar', height: 320, toolbar: { show: false } },
                xaxis: {
                    categories: pelaporLabels,
                    labels: {
                        rotate: -45,
                        rotateAlways: true,
                        style: { fontSize: '12px' }
                    }
                },
                colors: ['#8A2BE2'],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val > 0 ? val.toString() : '';
                    }
                },
                yaxis: {
                    title: { text: 'Jumlah Laporan' }
                }
            });
            chart.render();
            activeCharts.push(chart);
        }
    }

    // Jalankan saat halaman pertama kali dimuat
    document.addEventListener('livewire:init', renderCharts);
    // Jalankan ulang setiap navigasi (Livewire 3 wire:navigate)
    document.addEventListener('livewire:navigated', renderCharts);
</script>
@endpush
