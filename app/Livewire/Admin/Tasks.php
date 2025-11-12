<?php

namespace App\Livewire\Admin;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Notifications\NewTaskAssigned;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Tasks extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $description, $status = 'pending', $task_id;
    public $assigned_to, $due_date, $attachment;
    public $isOpen = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,in_progress,completed',
        'assigned_to' => 'nullable|exists:users,id',
        'due_date' => 'nullable|date|after:now',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240', // max 10MB
    ];

    public function render()
    {
        return view('livewire.admin.tasks', [
            'tasks' => Task::with('assignedUser')->latest()->paginate(10),
            'users' => User::all(),
        ]);
    }

    public function create()
    {
        $this->resetInput();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->title = null;
        $this->description = null;
        $this->status = 'pending';
        $this->assigned_to = null;
        $this->due_date = null;
        $this->attachment = null;
        $this->task_id = null;
    }

    public function store()
    {
        $this->validate();

        $filename = null;
        if ($this->attachment) {
            $filename = $this->attachment->store('tasks', 'public');
        }

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'assigned_to' => $this->assigned_to,
            'due_date' => $this->due_date,
            'attachment' => $filename,
        ]);

        // 🔔 Kirim notifikasi jika tugas ditugaskan ke user
        if ($this->assigned_to) {
            $user = User::find($this->assigned_to);
            if ($user) {
                Notification::send($user, new NewTaskAssigned($task));
            }
        }

        session()->flash('message', 'Tugas berhasil dibuat.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->task_id = $id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->assigned_to = $task->assigned_to;
        $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : null;
        $this->attachment = null; // tidak load file lama
        $this->openModal();
    }

    public function update()
    {
        $this->validate();

        $task = Task::findOrFail($this->task_id);

        $filename = $task->attachment;
        if ($this->attachment) {
            // Hapus file lama jika ada
            if ($task->attachment && Storage::disk('public')->exists($task->attachment)) {
                Storage::disk('public')->delete($task->attachment);
            }
            $filename = $this->attachment->store('tasks', 'public');
        }

        $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'assigned_to' => $this->assigned_to,
            'due_date' => $this->due_date,
            'attachment' => $filename,
        ]);

        // Kirim notifikasi jika user berubah atau baru ditambahkan
        if ($this->assigned_to && ($task->wasRecentlyCreated || $task->assigned_to !== (int) $this->assigned_to)) {
            $user = User::find($this->assigned_to);
            if ($user) {
                Notification::send($user, new NewTaskAssigned($task));
            }
        }

        session()->flash('message', 'Tugas berhasil diperbarui.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        if ($task->attachment && Storage::disk('public')->exists($task->attachment)) {
            Storage::disk('public')->delete($task->attachment);
        }
        $task->delete();
        session()->flash('message', 'Tugas berhasil dihapus.');
    }
}
