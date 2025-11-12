<?php

namespace App\Livewire\User;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Tasks extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $tasks = Task::with('assignedUser')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->paginate(6);

        // Tandai notifikasi terkait tugas ini sebagai sudah dibaca (opsional)
        auth()->user()->unreadNotifications
            ->where('data->task_id', '!=', null)
            ->each(function ($notification) {
                $notification->markAsRead();
            });

        return view('livewire.user.tasks', compact('tasks'));
    }
}
