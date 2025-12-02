<div class="bg-white dark:bg-black border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm mb-3">
    <div
        class="bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700 px-4 py-3 flex items-center justify-between rounded-t-lg">
        <flux:heading size="lg">Profile</flux:heading>

        @can('delete', $acct)
            <livewire:open.acct.delete :acct="$acct"/>
        @endcan
    </div>

    <div class="p-4">
        <div class="flex gap-3">
            <div class="shrink-0">
                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener" class="no-underline">
                    <flux:avatar size="lg" src="{{ $acct->avatar }}" :alt="$acct->name"/>
                </a>
            </div>
            <div class="flex-1">
                <flux:heading size="xl" class="mb-2">{{ $acct->name }}</flux:heading>

                <div class="flex gap-2 mb-3">
                    <flux:badge color="zinc" size="sm">{{ $acct->statuses_count }} posts</flux:badge>
                    <flux:badge color="zinc" size="sm">{{ $acct->following_count }} follows</flux:badge>
                    <flux:badge color="zinc" size="sm">{{ $acct->followers_count }} followers</flux:badge>
                </div>

                <div class="mb-3 text-gray-700 dark:text-gray-300">
                    {!! $acct->note !!}
                </div>

                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener"
                   class="no-underline text-blue-600 dark:text-blue-400 hover:underline text-sm">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
