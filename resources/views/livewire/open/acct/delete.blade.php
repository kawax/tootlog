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

            <form action="{{ route('accounts.delete', $acct->id) }}" method="post" class="inline">
                @csrf
                @method('DELETE')
                <flux:button type="submit" variant="danger">Delete</flux:button>
            </form>
        </div>
    </div>
</flux:modal>
