<?php

namespace App\Livewire;

use App\Models\Status;
use Livewire\Component;

class StatusToggle extends Component
{
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
