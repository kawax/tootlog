@if (empty($status->reblog))
    <div class="mb-2 rounded-lg border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-black">
        <div class="flex gap-3 p-4">
            <div class="shrink-0">
                <a href="{{ $status->account->url }}" class="no-underline" target="_blank" rel="nofollow noopener">
                    <img
                        class="max-w-24 rounded"
                        src="{{ $status->account->avatar }}"
                        alt="{{ $status->name }}"
                        title="{{ $status->name }}"
                    />
                </a>
            </div>
            <div class="flex-1">
                <h4 class="mb-1 text-lg font-semibold">
                    <a href="{{ $status->account->url }}" target="_blank" rel="nofollow noopener" class="no-underline"
                        >{{ $status->name }}
                    </a>
                    <small class="font-normal text-gray-500">
                        {{ $status->acct }}
                        @if ($status->account->locked)
                            <flux:icon.lock-closed variant="micro" class="inline" />
                        @endif
                    </small>
                </h4>

                @if (empty($status->spoiler_text))
                    <div class="mb-3">{!! $status->content !!}</div>
                @else
                    <details class="mb-3">
                        <summary class="cursor-pointer rounded bg-yellow-400 px-3 py-1 text-black">
                            {{ $status->spoiler_text }}
                        </summary>
                        <div class="mt-2">{!! $status->content !!}</div>
                    </details>
                @endif

                <div class="flex text-sm text-gray-600">
                    <a
                        href="{{
                            route('open.account.show', [
                                'user' => $status->account->user,
                                'username' => $status->account->username,
                                'domain' => $status->account->domain,
                                'status_id' => $status->status_id,
                            ])
                        }}"
                        class="pr-2 no-underline hover:underline"
                    >
                        <time
                            title="{{ $status->local_datetime->toAtomString() }}"
                            datetime="{{ $status->local_datetime->toAtomString() }}"
                        >
                            {{ $status->local_datetime->diffForHumans() }}
                        </time>
                    </a>

                    <a href="{{ $status->url }}" target="_blank" rel="nofollow noopener">
                        <flux:icon.arrow-top-right-on-square class="size-5" />
                    </a>
                </div>
            </div>
        </div>

        @include('status.footer')
    </div>
@else
    @include('status.reblog')
@endif
