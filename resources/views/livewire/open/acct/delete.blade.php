<?php

use App\Jobs\DeleteAccountJob;
use App\Models\Account;
use Livewire\Volt\Component;

new class extends Component
{
    public Account $acct;

    public function delete(): void
    {
        $this->authorize('delete', $this->acct);

        DeleteAccountJob::dispatch($this->acct);

        session()->flash('message', 'Account deletion scheduled.');

        $this->redirect(route('home'));
    }
}; ?>

<div>
    <flux:modal.trigger name="delete-modal">
        <flux:button variant="danger" size="sm">
            Delete...
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="delete-modal" class="max-w-md">
        <div>
            <flux:heading size="lg" class="mb-4">Delete account : {{ $acct->acct }}</flux:heading>

            <flux:text class="mb-6">
                All statuses will be delete. Can't undo.
            </flux:text>

            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button wire:click="delete" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
