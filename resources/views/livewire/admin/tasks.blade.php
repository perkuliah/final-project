<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-2 me-3">
        <h4 class="mb-0">Manajemen Tugas</h4>
        <button wire:click="create" class="btn bg-gradient-primary">
            <i class="fas fa-plus me-2"></i> Tambah Tugas
        </button>
    </div>

    <!-- Modal Form -->
    @if ($isOpen)
        <div class="modal show d-block" tabindex="-1" style="overflow-y: auto;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $task_id ? 'Edit Tugas' : 'Buat Tugas Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" wire:model="title">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" wire:model="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ditugaskan ke</label>
                            <select class="form-control" wire:model="assigned_to">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('assigned_to') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" wire:model="due_date">
                            @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran (opsional)</label>
                            <input type="file" class="form-control" wire:model="attachment">
                            @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                            @if ($task_id && $task_id && $tasks->contains('id', $task_id) && $tasks->where('id', $task_id)->first()->attachment)
                                <small class="d-block mt-1">
                                    <a href="{{ $tasks->where('id', $task_id)->first()->attachment_url }}" target="_blank" class="text-info">
                                        📎 Lihat file sebelumnya
                                    </a>
                                </small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="pending">Menunggu</option>
                                <option value="in_progress">Dikerjakan</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                        @if ($task_id)
                            <button type="button" class="btn bg-gradient-info" wire:click="update">Perbarui</button>
                        @else
                            <button type="button" class="btn bg-gradient-primary" wire:click="store">Simpan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Daftar Tugas -->
    <div class="row">
        @forelse ($tasks as $task)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->title }}</h5>
                        <p class="text-muted">{{ Str::limit($task->description, 80) }}</p>

                        <!-- ✅ Tempatkan di sini: info tambahan dalam loop card -->
                        @if ($task->assignedUser)
                            <p class="text-sm mb-1"><strong>Ditugaskan ke:</strong> {{ $task->assignedUser->name }}</p>
                        @endif
                        @if ($task->due_date)
                            <p class="text-sm mb-1">
                                <strong>Batas Waktu:</strong>
                                {{ \Carbon\Carbon::parse($task->due_date)->locale('id')->isoFormat('D MMM Y HH:mm') }}
                            </p>
                        @endif
                        @if ($task->attachment)
                            <a href="{{ $task->attachment_url }}" target="_blank"
                                class="btn btn-sm btn-outline-primary mb-2">
                                <i class="fas fa-paperclip"></i> Lampiran
                            </a>
                        @endif

                        <!-- Di dalam card admin -->
                        @if ($task->submission)
                            <a href="{{ asset('storage/' . $task->submission) }}" target="_blank"
                                class="btn btn-sm btn-outline-success mb-2">
                                <i class="fas fa-file-download"></i> Hasil Dikumpulkan
                            </a>
                        @endif
                        @if ($task->completed_at)
                            <p class="text-sm mb-0"><small>Selesai: {{ $task->completed_at->isoFormat('D MMM Y HH:mm') }}</small></p>
                        @endif

                        <span class="badge {{ $task->status_badge_class }} mt-2">
                            {{ $task->status_label }}
                        </span>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button wire:click="edit({{ $task->id }})" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button wire:click="delete({{ $task->id }})" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Yakin hapus tugas ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada tugas.</div>
            </div>
        @endforelse
    </div>

    {{ $tasks->links() }}
</div>

@push('scripts')
    <!-- Bootstrap & Livewire Modal Fix -->
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', () => {
                document.body.classList.remove('modal-open');
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            });
        });
    </script>
@endpush
