
<div x-data="{
    deleteId: null,
    deletepemasukan: null,
    viewLaporan: null,
    openViewModal(id) {
        $wire.getLaporan(id).then(data => {
            this.viewLaporan = data;
            const modal = new bootstrap.Modal(document.getElementById('viewLaporanModal'));
            modal.show();
        });
    }
}"
@confirm-delete.window="deleteId = $event.detail.id; deletepemasukan = $event.detail.pemasukan;">
    <div class="page-heading mb-4">
        <h3 class="font-weight-bolder text-dark">Laporan</h3>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('createlaporan') }}" wire:navigate class="btn bg-gradient-primary">
                Tambah Laporan
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Data Laporan Saya</h6>
                        <div class="w-25">
                            <input
                                type="text"
                                wire:model.live="search"
                                class="form-control"
                                placeholder="Cari Laporan..."
                            />
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div wire:loading.delay wire:target="search" class="text-center py-3">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div wire:loading.remove wire:target="search">
                        @if($laporans->isEmpty())
                            <div class="text-center py-4 text-muted">Tidak ada laporan ditemukan.</div>
                        @else
                            <!-- Scrollable table on mobile -->
                            <div class="table-responsive px-3" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                <table class="table align-items-center mb-0" id="laporanTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gambar</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pemasukan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelapor</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporans as $laporan)
                                        <tr>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p></td>
                                            <td>
                                                @if($laporan->gambar)
                                                    <img src="{{ asset($laporan->gambar) }}"
                                                        class="avatar avatar-sm rounded-2"
                                                        alt="Gambar Laporan">
                                                @else
                                                    <span class="text-secondary text-xs">–</span>
                                                @endif
                                            </td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</p></td>
                                            <td class="text-xs font-weight-bold">
                                                @if(!is_null($laporan->pemasukan) && is_numeric($laporan->pemasukan))
                                                    Rp {{ number_format($laporan->pemasukan, 0, ',', '.') }}
                                                @else
                                                    <span class="text-secondary">–</span>
                                                @endif
                                            </td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $laporan->user->name ?? '–' }}</p></td>
                                            <td>
                                                @php
                                                    $statusClass = match($laporan->status) {
                                                        'pending' => 'badge badge-sm bg-gradient-danger',
                                                        'diproses' => 'badge badge-sm bg-gradient-info',
                                                        default => 'badge badge-sm bg-gradient-success',
                                                    };
                                                @endphp
                                                <span class="{{ $statusClass }}">{{ ucwords($laporan->status) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    @click="openViewModal({{ $laporan->id }})"
                                                    class="btn btn-link text-dark px-1 py-0 mb-0">
                                                    <i class="fa fa-eye text-info"></i>
                                                </button>
                                                <a href="{{ route('editlaporan', $laporan->id) }}" wire:navigate
                                                    class="btn btn-link text-dark px-1 py-0 mb-0">
                                                    <i class="fa fa-edit text-info"></i>
                                                </a>
                                                <button
                                                    class="btn btn-link text-dark px-1 py-0 mb-0"
                                                    @click="if(confirm('Hapus data ini secara permanen?')) { @this.call('delete', {{ $laporan->id }}) }"
                                                    wire:loading.attr="disabled"
                                                    wire:target="delete">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Laporan -->
    <div class="modal fade" id="viewLaporanModal" tabindex="-1" aria-labelledby="viewLaporanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLaporanModalLabel">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" x-show="viewLaporan" x-cloak>
                    <div class="mb-3">
                        <strong>Tanggal:</strong>
                        <p x-text="viewLaporan.tanggal ? new Date(viewLaporan.tanggal).toLocaleDateString('id-ID') : '-'"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span :class="{
                            'badge badge-sm bg-gradient-danger': viewLaporan.status === 'pending',
                            'badge badge-sm bg-gradient-info': viewLaporan.status === 'diproses',
                            'badge badge-sm bg-gradient-success': viewLaporan.status === 'disetujui'
                        }" x-text="viewLaporan.status ? viewLaporan.status.charAt(0).toUpperCase() + viewLaporan.status.slice(1) : '-'"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Pemasukan:</strong>
                        <p x-text="viewLaporan.pemasukan ? 'Rp ' + parseFloat(viewLaporan.pemasukan).toLocaleString('id-ID') : '-'"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Pengeluaran:</strong>
                        <p x-text="viewLaporan.pengeluaran ? 'Rp ' + parseFloat(viewLaporan.pengeluaran).toLocaleString('id-ID') : '-'"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Judul:</strong>
                        <p x-text="viewLaporan.judul || '-'"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Deskripsi:</strong>
                        <p x-text="viewLaporan.deskripsi || '-'"></p>
                    </div>
                    <div class="mb-3" x-show="viewLaporan.gambar">
                        <strong>Gambar:</strong><br>
                        <img :src="viewLaporan.gambar" class="img-fluid rounded mt-2" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
