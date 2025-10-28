
<div>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="avatar avatar-2xl mb-3">
                                @if($foto)
                                    <img src="{{ asset('storage/users/'.$foto) }}" alt="Avatar" class="rounded-circle border-radius-lg shadow-sm" style="width:120px;height:120px;object-fit:cover;">
                                @else
                                    <img src="{{ asset('assetss/img/no-image.jpg') }}" alt="Avatar" class="rounded-circle border-radius-lg shadow-sm" style="width:120px;height:120px;object-fit:cover;">
                                @endif
                            </div>
                            <h5 class="font-weight-bold">{{ $name }}</h5>
                            <p class="text-muted text-sm mb-0">@if($username)@ {{ $username }}@else Belum ada username @endif</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card h-100">
                    <div class="card-header pb-0 px-4 pt-4">
                        <h6>Profile Information</h6>
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
                                    <input type="file" wire:model="newFoto" class="form-control">
                                    @error('newFoto') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Password (Opsional)</label>
                                    <input type="password" wire:model="password" class="form-control">
                                    @error('password') <small class="text-danger text-xs">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn bg-gradient-primary btn-sm">
                                        Simpan Perubahan
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