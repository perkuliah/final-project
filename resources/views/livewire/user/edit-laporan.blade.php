<div class="max-w-lg mx-auto mt-3">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="font-bold text-lg">Edit Laporan</h5>
        </div>
        <div class="card-body pt-0">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form wire:submit.prevent="update">
                <div class="mb-4">
                    <label class="form-label">Judul</label>
                    <input type="text" wire:model="judul" class="form-control">
                    @error('judul') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ❗ Field hanya bisa diubah oleh admin --}}
                @if (auth()->user()->role === 'admin')
                    <div class="mb-4">
                        <label class="form-label">Pemasukan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp </span>
                            <input type="text" wire:model="pemasukan" class="form-control ms-2"
                                x-data
                                x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                                placeholder="0">
                        </div>
                        @error('pemasukan') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Pengeluaran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" wire:model="pengeluaran" class="form-control ms-2"
                                x-data
                                x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                                placeholder="0">
                        </div>
                        @error('pengeluaran') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                @else
                    <div class="mb-4">
                        <label class="form-label">Pemasukan</label>
                        <input type="text" wire:model="pemasukan" class="form-control" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Pengeluaran</label>
                        <input type="text" wire:model="pengeluaran" class="form-control" readonly>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label">Deskripsi</label>
                    <textarea wire:model="deskripsi" rows="5" class="form-control"></textarea>
                    @error('deskripsi') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" wire:model="tanggal" class="form-control">
                    @error('tanggal') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tampilkan gambar lama sebagai preview read-only (opsional) --}}
                @if ($gambarLama)
                    <div class="mb-4">
                        <label class="form-label">Gambar Laporan</label>
                        <div class="mt-2">
                            <img src="{{ asset( $gambarLama) }}"
                                 alt="Gambar Laporan"
                                 class="rounded w-32 h-32 object-cover">
                        </div>
                    </div>
                @endif

                {{-- ✅ Tombol perubahan status hanya admin --}}
                @if (auth()->user()->role === 'admin')
                    <div class="mb-4">
                        <label class="form-label">Ubah Status</label>
                        <select wire:model="status" class="form-select">
                            <option value="menunggu">Menunggu</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        @error('status') <p class="text-sm text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="d-flex gap-2">
                    <button type="submit" class="btn bg-gradient-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
