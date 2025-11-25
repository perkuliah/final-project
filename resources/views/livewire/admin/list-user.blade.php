@section('title', 'Daftar Anggota')

<div>
    <div class="px-3 py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="font-weight-bolder mb-0">Daftar Anggota</h1>
                <p class="text-sm text-muted">Kelola data anggota aplikasi</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('register') }}" wire:navigate class="btn bg-gradient-primary btn-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Anggota
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <span class="alert-icon"><i class="fas fa-check"></i></span>
                <span class="alert-text">{{ session('message') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search Input -->
                    <div class="col-md-4">
                        <label class="form-label">Cari User</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   class="form-control"
                                   placeholder="Cari berdasarkan nama, email, username...">
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Filter Role</label>
                        <select wire:model.live="roleFilter" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <!-- Email Status Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Status Email</label>
                        <select wire:model.live="emailStatusFilter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="unverified">Belum Terverifikasi</option>
                        </select>
                    </div>

                    <!-- Items Per Page -->
                    <div class="col-md-2">
                        <label class="form-label">Data per Halaman</label>
                        <select wire:model.live="perPage" class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Active Filters Badges -->
                    @if($search || $roleFilter || $emailStatusFilter)
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <small class="text-muted">Filter aktif:</small>
                            @if($search)
                                <span class="badge bg-primary">
                                    Pencarian: "{{ $search }}"
                                    <button wire:click="$set('search', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;"></button>
                                </span>
                            @endif
                            @if($roleFilter)
                                <span class="badge bg-info">
                                    Role: {{ $roleFilter === 'admin' ? 'Admin' : 'User' }}
                                    <button wire:click="$set('roleFilter', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;"></button>
                                </span>
                            @endif
                            @if($emailStatusFilter)
                                <span class="badge bg-warning">
                                    Status: {{ $emailStatusFilter === 'verified' ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                    <button wire:click="$set('emailStatusFilter', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;"></button>
                                </span>
                            @endif
                            <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar User</h5>
                <small class="text-muted">Total: {{ $users->total() }} user</small>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" wire:click="sortBy('name')" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <span>Nama</span>
                                    @if ($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortAsc ? 'up' : 'down' }} ms-1"></i>
                                    @else
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" wire:click="sortBy('email')" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <span>Email</span>
                                    @if ($sortField === 'email')
                                        <i class="fas fa-sort-{{ $sortAsc ? 'up' : 'down' }} ms-1"></i>
                                    @else
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">WhatsApp</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Email</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if ($user->foto)
                                                <img src="{{ asset('storage/users/' . $user->foto) }}" class="avatar avatar-sm me-3" alt="{{ $user->name }}">
                                            @else
                                                <div class="avatar avatar-sm me-3 bg-gradient-secondary">
                                                    <span class="text-white">{{ substr($user->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $user->username }}</p>
                                </td>
                                <td>
                                    @if ($user->whatsapp)
                                        <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank" class="text-xs font-weight-bold text-primary">
                                            {{ $user->whatsapp }}
                                        </a>
                                    @else
                                        <span class="text-xs text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-gradient-danger">Admin</span>
                                    @elseif($user->role === 'user')
                                        <span class="badge bg-gradient-info">User</span>
                                    @else
                                        <span class="badge bg-gradient-secondary">{{ ucfirst($user->role) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-gradient-success">Verified</span>
                                    @else
                                        <span class="badge bg-gradient-warning">Unverified</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 text-truncate" style="max-width: 150px;">{{ $user->alamat ?? '-' }}</p>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('list-user-edit', $user->id) }}" wire:navigate class="text-info px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $user->id }})" class="text-danger px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-users text-gray-400" style="font-size: 2rem;"></i>
                                    <h6 class="mt-3 mb-1">Tidak ada data user</h6>
                                    <p class="text-sm text-muted">
                                        @if($search || $roleFilter || $emailStatusFilter)
                                            Coba ubah filter pencarian Anda
                                        @else
                                            Mulai dengan menambah user baru.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal && $selectedUser)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus User</h5>
                        <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus user <strong>{{ $selectedUser->name }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Batal</button>
                        <button type="button" class="btn bg-gradient-danger" wire:click="deleteUser">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
