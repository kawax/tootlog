<div class="p-6 w-full">
    <flux:heading size="lg" level="3">{{ __('Stats') }}</flux:heading>
    <flux:subheading size="md" class="mb-3">
        {{ __('') }}
    </flux:subheading>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <flux:text>{{ __('Statuses') }}</flux:text>
            <flux:heading size="xl"
                          class="mb-1">{{ auth()->user()->loadCount('statuses')->statuses_count }}</flux:heading>
        </div>
        <div>
            <flux:text>{{ __('Accounts') }}</flux:text>
            <flux:heading size="xl"
                          class="mb-1">{{ auth()->user()->loadCount('accounts')->accounts_count }}</flux:heading>
        </div>
    </div>
</div>
