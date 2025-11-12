<?php

namespace App\Livewire\User;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmitTask extends Component
{
    use WithFileUploads;

    public $task_id;
    public $submission_file;

    protected $rules = [
        'submission_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:10240', // max 10MB
    ];

    protected $messages = [
        'submission_file.required' => 'File hasil tugas wajib diunggah.',
        'submission_file.mimes' => 'Format file harus: PDF, DOC, DOCX, JPG, PNG, ZIP, atau RAR.',
        'submission_file.max' => 'Ukuran file maksimal 10 MB.',
    ];

    public function mount($task_id)
    {
        $this->task_id = $task_id;
    }

    public function submit()
    {
        $this->validate();

        $task = Task::where('id', $this->task_id)
            ->where('assigned_to', Auth::id())
            ->firstOrFail();

        // Simpan file ke storage/app/public/submissions
        $filename = 'submission_' . $task->id . '_' . time() . '.' . $this->submission_file->getClientOriginalExtension();
        $this->submission_file->storeAs('public/submissions', $filename);

        // Simpan path ke kolom `submission` di tabel tasks
        $task->update([
            'submission' => 'submissions/' . $filename,
            'status' => 'completed',
        ]);

        // Opsional: kirim notifikasi ke admin/guru
        // Notification::send($admin, new TaskSubmitted($task));

        session()->flash('success', 'Tugas berhasil dikumpulkan!');
        $this->dispatch('taskSubmitted'); // Event untuk refresh atau alert
        $this->reset('submission_file');
    }

    public function render()
    {
        return view('livewire.user.submit-task');
    }
}
