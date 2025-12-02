<?php

use App\Models\Status;
use Livewire\Volt\Component;

/**
 * 投稿の表示・非表示を切り替える
 */
new class extends Component
{
    public Status $status;

    public bool $show = true;

    public function mount(Status $status): void
    {
        $this->show = ! $status->trashed();
    }

    public function toggle(): void
    {
        $this->authorize('update', $this->status);

        if ($this->status->trashed()) {
            $this->status->restore();
            $this->show = true;
        } else {
            $this->status->delete();
            $this->show = false;
        }

        cache()->forget('recents/open/'.$this->status->account->user_id);

        $this->dispatch('status-updated');
    }
}; ?>

<flux:field variant="inline">
    <flux:switch
        wire:key="{{ $status->id }}"
        wire:click="toggle"
        wire:model.live="show"
        align="left"
        :label="!$status->trashed() ? 'Public' : 'Private'"
    />
</flux:field>
