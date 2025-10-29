<div>
    <div class="px-3 py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="font-weight-bolder mb-0">Daftar User</h1>
                <p class="text-sm text-muted">Kelola data user aplikasi</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('register') }}" class="btn bg-gradient-primary btn-sm">
                    <i class="fas fa-plus me-2"></i> Tambah User
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
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">Cari User</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text"
                                   wire:model.debounce.300ms="search"
                                   class="form-control"
                                   placeholder="Cari berdasarkan nama, email, username, atau role...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Data per Halaman</label>
                        <select wire:model="perPage" class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" wire:click="sortBy('name')" style="cursor: pointer;">
                                Nama
                                @if ($sortField === 'name')
                                    {!! $sortAsc ? '<i class="fas fa-sort-up ms-1"></i>' : '<i class="fas fa-sort-down ms-1"></i>' !!}
                                @endif
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" wire:click="sortBy('email')" style="cursor: pointer;">
                                Email
                                @if ($sortField === 'email')
                                    {!! $sortAsc ? '<i class="fas fa-sort-up ms-1"></i>' : '<i class="fas fa-sort-down ms-1"></i>' !!}
                                @endif
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
                                                <img src="{{ asset('storage/' . $user->foto) }}" class="avatar avatar-sm me-3" alt="{{ $user->name }}">
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
                                    
                                    <a href="{{ route('list-user-edit', $user->id) }}" class="text-info px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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
                                    <p class="text-sm text-muted">Mulai dengan menambah user baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links('livewire::bootstrap') }}
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