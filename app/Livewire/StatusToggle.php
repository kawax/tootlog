<?php

namespace App\Livewire;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class StatusToggle extends Component
{
    use WithPagination;

    public Status $status;

    public function toggle(): void
    {
        if ($this->status->trashed()) {
            $this->status->restore();
        } else {
            $this->status->delete();
        }
    }
}
