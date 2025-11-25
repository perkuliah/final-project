@section('title', 'Profile')

<div>
    <style>
        .img-profile {
    width: 185px;
    height: 250px;
    object-fit: cover;
    border-radius: 50px;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

    </style>
    <main class="main-content position-relative max-height-vh-90 h-90 border-radius-lg">
        <div class="container-fluid ">
            <div class="row">
                <!-- Sidebar Avatar -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="mb-4 text-center mt-7">
                                @if($foto)
                                    <img src="{{ asset('storage/users/' . $foto) }}" class="img-profile" alt="Avatar">
                                @else
                                    <img src="{{ asset('assetss/img/no-image.jpg') }}" class="img-profile" alt="Avatar">
                                        @endif
                                    </div>

                                <h5 class="font-weight-bold">{{ $name }}</h5>
                                <p class="text-muted text-sm mb-0">
                                    {{ $username ? '@' . $username : 'Belum ada username' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Profil -->
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="card h-100">
                        <div class="card-header pb-0 px-4 pt-4">
                            <h6>Profile Information</h6>
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body pt-0 px-4 pb-4">
                            <form wire:submit.prevent="updateProfile">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" wire:model="name" class="form-control">
                                        @error('name') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" wire:model="username" class="form-control">
                                        @error('username') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" wire:model="email" class="form-control">
                                        @error('email') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">WhatsApp</label>
                                        <input type="text" wire:model="whatsapp" class="form-control">
                                        @error('whatsapp') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea wire:model="alamat" class="form-control" rows="3"></textarea>
                                        @error('alamat') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Foto Profil</label>
                                        <input type="file" wire:model="newFoto" class="form-control" accept="image/*">
                                        @error('newFoto') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                        @if($newFoto)
                                            <div class="mt-2">
                                                <p class="text-sm text-muted">Preview:</p>
                                                <img src="{{ $newFoto->temporaryUrl() }}"
                                                     class="img-thumbnail"
                                                     style="max-height: 150px; object-fit: cover;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Password (Opsional)</label>
                                        <input type="password" wire:model="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
                                        @error('password') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                                class="btn bg-gradient-primary btn-sm"
                                                wire:loading.attr="disabled">
                                            <span wire:loading.remove>Simpan Perubahan</span>
                                            <span wire:loading>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
    </main>
</div>

{{-- SweetAlert setelah update sukses --}}
@script
<script>
    $wire.on('profileUpdated', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Profil Anda telah diperbarui.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    });
</script>
@endscript
