<?php

namespace App\Http\Livewire;

use App\Models\Status;
use Livewire\Component;

class StatusToggle extends Component
{
    public Status $status;

    public function toggle()
    {
        if ($this->status->trashed()) {
            $this->status->restore();
        } else {
            $this->status->delete();
        }
    }

    public function render()
    {
        return view('livewire.status-toggle');
    }
}
