<?php

use App\Models\Account;
use Livewire\Volt\Component;

new class extends Component
{
    public Account $acct;

    public bool $locked = true;

    public function mount(): void
    {
        $this->locked = $this->acct->locked;
    }

    public function toggle(): void
    {
        $this->authorize('update', $this->acct);

        $this->acct->locked = ! $this->acct->locked;
        $this->locked = $this->acct->locked;
        $this->acct->save();

        $this->dispatch('account-updated');

        cache()->forget('archives/'.$this->acct->user->id);
    }
}; ?>

<flux:field variant="inline">
    <flux:legend>Locked</flux:legend>

    <flux:switch
        wire:click="toggle"
        wire:model.live="locked"
        align="left"
        :label="$acct->locked ? 'This account is private': 'This account is public to everyone'"
    />
</flux:field>
