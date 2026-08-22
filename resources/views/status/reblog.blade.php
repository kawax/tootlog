<div class="mb-2 rounded-lg bg-white shadow-sm ring-1 ring-sky-500 dark:bg-black dark:ring-sky-700">
    <div class="flex items-center gap-2 rounded-t-lg bg-sky-500 px-4 py-2 text-white dark:bg-sky-700">
        <img
            class="size-6 rounded-full object-cover"
            src="{{ $status->account->avatar }}"
            alt="{{ $status->name }}"
            title="{{ $status->name }}"
        />
        <span>{{ $status->name }} reblogged at {{ $status->local_datetime->diffForHumans() }}</span>
    </div>

    <div class="p-4">
        <div class="flex gap-3">
            <div class="shrink-0">
                <a
                    href="{{ $status->reblog->account_url }}"
                    class="no-underline"
                    target="_blank"
                    rel="nofollow noopener"
                >
                    <img
                        class="max-w-24 rounded"
                        src="{{ $status->reblog->avatar }}"
                        alt="{{ $status->reblog->name }}"
                        title="{{ $status->reblog->name }}"
                    />
                </a>
            </div>
            <div class="flex-1">
                <h4 class="mb-1 text-lg font-semibold">
                    <a
                        href="{{ $status->reblog->account_url }}"
                        class="no-underline"
                        target="_blank"
                        rel="nofollow noopener"
                    >{{ $status->reblog->name }}</a>
                    <small class="font-normal text-gray-500">{{ $status->reblog->acct }}</small>
                </h4>

                @if (empty($status->reblog->spoiler_text))
                    <div class="mb-3">{!! $status->reblog->content !!}</div>
                @else
                    <details class="mb-3">
                        <summary class="cursor-pointer rounded bg-yellow-400 px-3 py-1 text-sm text-black">
                            {{ $status->reblog->spoiler_text }}
                        </summary>
                        <div class="mt-2">{!! $status->reblog->content !!}</div>
                    </details>
                @endif

                <div class="mb-2 text-sm text-gray-600">
                    <a
                        href="{{ $status->reblog->url }}"
                        target="_blank"
                        rel="nofollow noopener"
                        class="no-underline hover:underline"
                    >
                        <time datetime="{{ $status->reblog->created_at->toAtomString() }}">
                            {{ $status->reblog->created_at->diffForHumans() }}
                        </time>
                    </a>
                </div>

                @if (filled($status->account->user))
                    <div class="text-sm text-gray-600">
                        <a
                            href="{{
                                route('open.account.show', [
                                    'user' => $status->account->user,
                                    'username' => $status->account->username,
                                    'domain' => $status->account->domain,
                                    'status_id' => $status->status_id,
                                ])
                            }}"
                            class="no-underline hover:underline"
                        >
                            {{ $status->account->acct . '/' . $status->status_id }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('status.footer')
</div>
