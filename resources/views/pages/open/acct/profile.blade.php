<div class="mb-3 rounded-lg border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-black">
    <div class="flex items-center justify-between rounded-t-lg border-b border-neutral-200 bg-white px-4 py-3 dark:border-neutral-700 dark:bg-neutral-900">
        <flux:heading size="lg">Profile</flux:heading>

        @can('delete', $acct)
            <livewire:pages::open.acct.delete :acct="$acct" />
        @endcan
    </div>

    <div class="p-4">
        <div class="flex gap-3">
            <div class="shrink-0">
                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener" class="no-underline">
                    <flux:avatar size="lg" src="{{ $acct->avatar }}" :alt="$acct->name" />
                </a>
            </div>
            <div class="flex-1">
                <flux:heading size="xl" class="mb-2">{{ $acct->name }}</flux:heading>

                <div class="mb-3 flex gap-2">
                    <flux:badge color="zinc" size="sm">{{ $acct->statuses_count }} posts</flux:badge>
                    <flux:badge color="zinc" size="sm">{{ $acct->following_count }} follows</flux:badge>
                    <flux:badge color="zinc" size="sm">{{ $acct->followers_count }} followers</flux:badge>
                </div>

                <div class="mb-3 text-gray-700 dark:text-gray-300">{!! $acct->note !!}</div>

                <a
                    href="{{ $acct->url }}"
                    target="_blank"
                    rel="nofollow noopener"
                    class="text-sm text-blue-600 no-underline hover:underline dark:text-blue-400"
                >
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>

    @can('update', $acct)
        <div class="rounded-b-lg bg-neutral-100 p-3 dark:bg-neutral-900">
            <livewire:pages::open.acct.locked-toggle :acct="$acct"></livewire:pages::open.acct.locked-toggle>
        </div>
    @endcan
</div>
