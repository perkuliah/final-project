@section('title', 'Laporan Saya')

<div x-data="{ deleteId: null, deleteJudul: null }" @confirm-delete.window="deleteId = $event.detail.id; deleteJudul = $event.detail.judul;">
    <div class="page-heading mb-4">
        <h3 class="text-2xl font-bold text-gray-800">Laporan</h3>
    </div>

    <div class="flex justify-end items-center mb-4">
        <a href="{{ route('createlaporanuser') }}" wire:navigate class="btn btn-primary">
            Tambah Laporan
        </a>
    </div>

    <!-- Added flash message display for success/error -->
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

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Laporan Saya</h5>
                <input
                    type="text"
                    wire:model.live="search"
                    class="form-control w-25"
                    placeholder="Cari Laporan..."
                />
            </div>

            <!-- Loading indicator -->
            <div wire:loading.delay wire:target="search" class="py-4">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div wire:loading.remove wire:target="search">
                        @if($laporans->isEmpty())
                            <div class="text-center py-4 text-muted">Tidak ada laporan ditemukan.</div>
                        @else
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Tanggal Laporan</th>
                                        <th>Laporan pemasukan</th>
                                        <th>Pelapor</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporans as $laporan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($laporan->gambar)
                                                    <img src="{{ asset( $laporan->gambar) }}"
                                                        alt="Gambar Laporan"
                                                        class="img-fluid rounded" style="max-width: 80px; height: auto">
                                                @else
                                                    <span class="text-muted">–</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                            <td>{{ is_numeric($laporan->pemasukan) ? 'Rp ' . number_format($laporan->pemasukan, 0, ',', '.') : '–' }}</td>
                                            <td>{{ $laporan->user->name ?? '–' }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($laporan->status === 'pending')
                                                        bg-gradient-danger
                                                    @elseif($laporan->status === 'diproses')
                                                        bg-gradient-info
                                                    @else
                                                        bg-gradient-success
                                                    @endif">
                                                    {{ ucwords($laporan->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('editlaporan', $laporan->id) }}" wire:navigate class="btn btn-warning btn-sm mx-1">
                                                    Edit
                                                </a>
                                                <!-- Updated delete button to use Alpine.js dispatch -->
                                                <button
                                                    class="btn btn-danger btn-sm mx-1"
                                                    @click="
                                                        if(confirm('Hapus laporan berjudul \"{{ addslashes($laporan->judul) }}\" secara permanen?')) {
                                                            @this.call('delete', {{ $laporan->id }})
                                                        }
                                                    "
                                                    wire:loading.attr="disabled"
                                                    wire:target="delete">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
