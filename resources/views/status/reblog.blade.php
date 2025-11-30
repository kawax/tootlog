<div class="bg-white dark:bg-black rounded-lg shadow-sm ring-1 ring-sky-500 dark:ring-sky-700 mb-2">
    <div class="bg-sky-500 dark:bg-sky-700 text-white px-4 py-2 rounded-t-lg flex items-center gap-2">
        <img class="rounded-full size-6 object-cover"
             src="{{ $status->account->avatar }}"
             alt="{{ $status->name }}"
             title="{{ $status->name }}">
        <span>{{ $status->name }} reblogged at {{ $status->local_datetime->diffForHumans() }}</span>
    </div>

    <div class="p-4">
        <div class="flex gap-3">
            <div class="shrink-0">
                <a href="{{ $status->reblog->account_url }}" class="no-underline" target="_blank"
                   rel="nofollow noopener">
                    <img class="rounded max-w-24"
                         src="{{ $status->reblog->avatar }}"
                         alt="{{ $status->reblog->name }}"
                         title="{{ $status->reblog->name }}">
                </a>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-semibold mb-1">
                    <a href="{{ $status->reblog->account_url }}" class="no-underline" target="_blank"
                       rel="nofollow noopener">{{ $status->reblog->name }}</a>
                    <small class="text-gray-500 font-normal">{{ $status->reblog->acct }}</small>
                </h4>

                @if(empty($status->reblog->spoiler_text))
                    <div class="mb-3">
                        {!! $status->reblog->content !!}
                    </div>
                @else
                    <details class="mb-3">
                        <summary class="bg-yellow-400 text-black px-3 py-1 rounded cursor-pointer text-sm">
                            {{ $status->reblog->spoiler_text }}
                        </summary>
                        <div class="mt-2">
                            {!! $status->reblog->content !!}
                        </div>
                    </details>
                @endif

                <div class="text-sm text-gray-600 mb-2">
                    <a href="{{ $status->reblog->url }}" target="_blank" rel="nofollow noopener" class="no-underline">
                        <time datetime="{{ $status->reblog->created_at->toAtomString() }}">
                            {{ $status->reblog->created_at->diffForHumans() }}
                        </time>
                    </a>
                </div>

                @if(filled($status->account->user))
                    <div class="text-sm text-gray-600">
                        <a href="{{ route('open.account.show', [
                            'user' => $status->account->user,
                            'username' => $status->account->username,
                            'domain' => $status->account->domain,
                            'status_id' => $status->status_id
                            ]) }}" class="no-underline">
                            {{ $status->account->acct . '/' . $status->status_id }}
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>

    @include('status.footer')

</div>
