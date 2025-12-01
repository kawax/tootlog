<flux:field variant="inline">
    <flux:switch
        wire:key="{{ $status->id }}"
        wire:click="toggle"
        wire:model.live="show"
    />
    <flux:label>
        @unless($status->trashed())
            Show
        @else
            Hide
        @endunless
    </flux:label>
</flux:field>
