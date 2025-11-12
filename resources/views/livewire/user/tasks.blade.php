<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Tugas Saya</h4>
    </div>

    @if ($tasks->isEmpty())
        <div class="alert alert-info text-center">
            Anda belum memiliki tugas yang ditugaskan.
        </div>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="text-muted">{{ Str::limit($task->description, 80) }}</p>

                            @if ($task->due_date)
                                <p class="text-sm mb-1">
                                    <strong>Batas Waktu:</strong>
                                    {{ \Carbon\Carbon::parse($task->due_date)->locale('id')->isoFormat('D MMM Y HH:mm') }}
                                    @if (\Carbon\Carbon::now()->gt($task->due_date) && $task->status !== 'completed')
                                        <span class="badge bg-danger ms-2">Terlambat</span>
                                    @endif
                                </p>
                            @endif

                            @if ($task->attachment)
                                <a href="{{ $task->attachment_url }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-paperclip"></i> Lampiran
                                </a>
                            @endif

                            <span class="badge {{ $task->status_badge_class }} mt-2">
                                {{ $task->status_label }}
                            </span>
                        </div>

                        {{-- Footer card: tombol kumpulkan atau status selesai --}}
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            @if ($task->status !== 'completed')
                                @livewire('user.submit-task', ['task_id' => $task->id], key('submit' . $task->id))
                            @else
                                <span class="text-success">✅ Sudah Dikumpulkan</span>
                                @if ($task->submission)
                                    <a href="{{ $task->submission_url }}" target="_blank"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-file-download"></i> Lihat Hasil
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $tasks->links() }}
    @endif
</div>
