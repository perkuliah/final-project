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

    .saldo-positif {
        color: #17ad37;
        font-weight: bold;
    }

    .saldo-negatif {
        color: #ea0606;
        font-weight: bold;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }

    .avatar {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.875rem;
    }

    .avatar-xs {
        width: 24px;
        height: 24px;
        font-size: 0.75rem;
    }

    .loading-spinner {
        animation: spin 1s linear infinite;
    }
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
                                            <i class="fas fa-hourglass-half loading-spinner"></i>
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
                                            <i class="fas fa-sync-alt loading-spinner"></i>
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

            <!-- TABEL KEUANGAN PER PELAPOR -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Keuangan per Pelapor</h5>
                            <div class="btn-group">
                                <button type="button"
                                        class="btn btn-success dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        wire:loading.attr="disabled"
                                        {{ empty($keuanganPerPelapor) ? 'disabled' : '' }}>
                                    <i class="fas fa-download me-2"></i>
                                    <span wire:loading.remove wire:target="downloadExcel">Download</span>
                                    <span wire:loading wire:target="downloadExcel">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button wire:click="downloadExcel"
                                                class="dropdown-item"
                                                type="button"
                                                wire:loading.attr="disabled"
                                                {{ empty($keuanganPerPelapor) ? 'disabled' : '' }}>
                                            <i class="fas fa-file-excel text-success me-2"></i>
                                            <span wire:loading.remove wire:target="downloadExcel">Excel</span>
                                            <span wire:loading wire:target="downloadExcel">
                                                <i class="fas fa-spinner fa-spin me-2"></i>Exporting...
                                            </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(empty($keuanganPerPelapor))
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Tidak ada data keuangan</h6>
                                    <p class="text-sm text-muted">Data keuangan per pelapor akan muncul di sini</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center" style="width: 5%">No</th>
                                                <th style="width: 25%">Nama Pelapor</th>
                                                <th class="text-center" style="width: 15%">Jumlah Laporan</th>
                                                <th class="text-end" style="width: 20%">Total Pemasukan</th>
                                                <th class="text-end" style="width: 20%">Total Pengeluaran</th>
                                                <th class="text-end" style="width: 15%">Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                                $grandTotalPemasukan = 0;
                                                $grandTotalPengeluaran = 0;
                                                $grandTotalSaldo = 0;
                                            @endphp

                                            @foreach($keuanganPerPelapor as $nama => $data)
                                                @php
                                                    $grandTotalPemasukan += $data['pemasukan'];
                                                    $grandTotalPengeluaran += $data['pengeluaran'];
                                                    $grandTotalSaldo += $data['saldo'];
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $counter++ }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-xs bg-light rounded me-2">
                                                                <span class="text-dark">{{ substr($nama, 0, 2) }}</span>
                                                            </div>
                                                            {{ $nama }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary rounded-pill">{{ $data['jumlah_laporan'] }}</span>
                                                    </td>
                                                    <td class="text-end text-success fw-bold">
                                                        Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-end text-danger fw-bold">
                                                        Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-end fw-bold {{ $data['saldo'] >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                                                        Rp {{ number_format($data['saldo'], 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-secondary fw-bold">
                                            <tr>
                                                <td colspan="2" class="text-center">TOTAL KESELURUHAN</td>
                                                <td class="text-center">{{ $totalLaporan }}</td>
                                                <td class="text-end text-success">
                                                    Rp {{ number_format($grandTotalPemasukan, 0, ',', '.') }}
                                                </td>
                                                <td class="text-end text-danger">
                                                    Rp {{ number_format($grandTotalPengeluaran, 0, ',', '.') }}
                                                </td>
                                                <td class="text-end {{ $grandTotalSaldo >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                                                    Rp {{ number_format($grandTotalSaldo, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
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
    if (typeof window.activeCharts === 'undefined') {
        window.activeCharts = [];
    }

    function destroyAllCharts() {
        window.activeCharts.forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        window.activeCharts = [];
    }

    function safeJsonParse(data) {
        try {
            return typeof data === 'string' ? JSON.parse(data) : data;
        } catch (e) {
            console.error('JSON parse error:', e);
            return {};
        }
    }

    function cleanChartData(data) {
        if (typeof data === 'string') {
            // Bersihkan string dari karakter problematic
            return data.replace(/[^\x20-\x7E\xA0-\xFF]/g, '');
        }
        return data;
    }

    function renderCharts() {
        destroyAllCharts();

        try {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const laporanPerBulan = safeJsonParse(@json($laporanPerBulan ?: []));

            // --- Grafik Laporan per Bulan ---
            const barTarget = document.querySelector("#grafik-laporan-bar");
            if (barTarget) {
                const dataPerBulan = months.map((m, i) => {
                    const monthKey = String(i + 1).padStart(2, '0');
                    return Number(laporanPerBulan[monthKey]) || 0;
                });

                const chart = new ApexCharts(barTarget, {
                    series: [{ name: 'Laporan', data: dataPerBulan }],
                    chart: { type: 'bar', height: 320, toolbar: { show: false } },
                    xaxis: { categories: months },
                    colors: ['#2152ff'],
                    plotOptions: { bar: { borderRadius: 6, dataLabels: { position: 'top' } } }
                });
                 chart.render();
            window.activeCharts.push(chart);
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
            window.activeCharts.push(chart);
        }

            // --- Pemasukan per Lokasi ---
            const pemasukanPerLokasi = safeJsonParse(@json($pemasukanPerLokasi ?: []));
            const lokasiLabels = Object.keys(pemasukanPerLokasi).map(label => cleanChartData(label));

            const chartPemasukan = document.querySelector("#grafik-pemasukan-lokasi");
            if (chartPemasukan && lokasiLabels.length > 0) {
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
            window.activeCharts.push(chart);
        }

            // --- Pengeluaran per Lokasi ---
            const pengeluaranPerLokasi = safeJsonParse(@json($pengeluaranPerLokasi ?: []));
            const chartPengeluaran = document.querySelector("#grafik-pengeluaran-lokasi");
            if (chartPengeluaran && lokasiLabels.length > 0) {
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
            window.activeCharts.push(chart);
        }

            // --- Laporan per Pelapor ---
            const laporanPerPelapor = safeJsonParse(@json($laporanPerPelapor ?: []));
            const pelaporLabels = Object.keys(laporanPerPelapor).map(label => cleanChartData(label));
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
            window.activeCharts.push(chart);
        }

        } catch (error) {
            console.error('Error rendering charts:', error);
        }
    }

    // Jalankan saat halaman pertama kali dimuat
    document.addEventListener('livewire:init', renderCharts);
    // Jalankan ulang setiap navigasi (Livewire 3 wire:navigate)
    document.addEventListener('livewire:navigated', renderCharts);
</script>
@endpush
