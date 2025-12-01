<?php

namespace App\Livewire;

use App\Models\Status;
use Livewire\Component;

/**
 * 投稿の表示・非表示を切り替える
 */
class StatusToggle extends Component
{
    public Status $status;

    public bool $show = true;

    public function mount(Status $status): void
    {
        $this->show = ! $status->trashed();
    }

    public function toggle(): void
    {
        if ($this->status->trashed()) {
            $this->status->restore();
            $this->show = true;
        } else {
            $this->status->delete();
            $this->show = false;
        }
    }
}
