<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.Layouts.app')]
class ListUser extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortField = 'name';
    public $sortAsc = true;
    public $selectedUser = null;
    public $showDeleteModal = false;
    public $roleFilter = '';
    public $emailStatusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 5],
        'sortField' => ['except' => 'name'],
        'sortAsc' => ['except' => true],
        'roleFilter' => ['except' => ''],
        'emailStatusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingEmailStatusFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->roleFilter = '';
        $this->emailStatusFilter = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function confirmDelete($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        if ($this->selectedUser) {
            $this->selectedUser->delete();
            session()->flash('message', 'User berhasil dihapus!');
            $this->showDeleteModal = false;
            $this->selectedUser = null;
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('username', 'like', '%' . $this->search . '%')
                      ->orWhere('whatsapp', 'like', '%' . $this->search . '%')
                      ->orWhere('alamat', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->emailStatusFilter, function ($query) {
                if ($this->emailStatusFilter === 'verified') {
                    $query->whereNotNull('email_verified_at');
                } elseif ($this->emailStatusFilter === 'unverified') {
                    $query->whereNull('email_verified_at');
                }
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.list-user', [
            'users' => $users
        ]);
    }
}
