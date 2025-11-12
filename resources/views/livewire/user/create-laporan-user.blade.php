<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <!-- Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Buat Laporan Baru</h4>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white text-sm mb-0">Isi form berikut untuk membuat laporan keuangan baru</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Flash Message -->
                    @if (session()->has('success'))
                        <div class="alert alert-success text-white" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ni ni-like-2 text-lg me-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form wire:submit.prevent="save" enctype="multipart/form-data">
                        <!-- Judul & Lokasi -->
                        <div class="row mb-4">
                            <!-- Judul -->
                            <div class="col-md-6">
                                <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ni ni-ruler-pencil"></i>
                                    </span>
                                    <input
                                        type="text"
                                        wire:model="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        placeholder="Contoh: Laporan Keuangan Bulan Januari"
                                    >
                                </div>
                                @error('judul')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ni ni-pin-3"></i>
                                    </span>
                                    <select
                                        wire:model="lokasi"
                                        class="form-select @error('lokasi') is-invalid @enderror"
                                    >
                                        <option value="">Pilih Lokasi Laporan</option>
                                        @foreach($this->lokasiOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('lokasi')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pemasukan & Pengeluaran -->
                        <div class="row mb-4">
                            <!-- Pemasukan -->
                            <div class="col-md-6">
                                <label class="form-label">Pemasukan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input
                                        type="number"
                                        wire:model="pemasukan"
                                        class="form-control @error('pemasukan') is-invalid @enderror"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                    >
                                </div>
                                @error('pemasukan')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Pengeluaran -->
                            <div class="col-md-6">
                                <label class="form-label">Pengeluaran</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input
                                        type="number"
                                        wire:model="pengeluaran"
                                        class="form-control @error('pengeluaran') is-invalid @enderror"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                    >
                                </div>
                                @error('pengeluaran')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Error jika kedua kosong -->
                        @if($errors->has('pemasukan') && $errors->has('pengeluaran'))
                            <div class="alert alert-danger text-white mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="ni ni-fat-remove text-lg me-2"></i>
                                    <span>Minimal isi salah satu: pemasukan atau pengeluaran.</span>
                                </div>
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Laporan <span class="text-danger">*</span></label>
                            <textarea
                                wire:model="deskripsi"
                                rows="4"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Jelaskan detail laporan keuangan..."
                            ></textarea>
                            @error('deskripsi')
                                <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                    <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tanggal & Gambar -->
                        <div class="row mb-4">
                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Laporan <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    wire:model="tanggal"
                                    max="{{ now()->format('Y-m-d') }}"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                >
                                @error('tanggal')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div class="col-md-6">
                                <label class="form-label">Bukti Gambar (Opsional)</label>
                                <input
                                    type="file"
                                    wire:model="gambar"
                                    accept="image/jpg,image/jpeg,image/png"
                                    class="form-control @error('gambar') is-invalid @enderror"
                                >
                                @error('gambar')
                                    <div class="text-danger text-sm mt-1 d-flex align-items-center">
                                        <i class="ni ni-fat-remove me-1"></i> {{ $message }}
                                    </div>
                                @enderror

                                <!-- Info File -->
                                <p class="text-muted text-xs mt-1">
                                    <i class="ni ni-info-bold me-1"></i> Format: JPG, JPEG, PNG | Maksimal: 5MB
                                </p>

                                <!-- Preview -->
                                @if ($gambar)
                                    <div class="mt-2">
                                        <img src="{{ $gambar->temporaryUrl() }}" class="img-thumbnail rounded" width="120">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between align-items-center mt-6">
                            <p class="text-sm mb-0">
                                <i class="ni ni-lock-circle-open me-1"></i> Data Anda akan disimpan dengan aman
                            </p>
                            <div>
                                <a href="javascript:history.back()" class="btn btn-outline-secondary me-2">Batal</a>
                                <button
                                    type="submit"
                                    class="btn bg-gradient-primary"
                                    wire:loading.attr="disabled"
                                >
                                    <span wire:loading.remove>
                                        <i class="ni ni-check-bold me-1"></i> Simpan Laporan
                                    </span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
