<?php

namespace App\Livewire\Atom;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.atom.sidebar');
    }
}
