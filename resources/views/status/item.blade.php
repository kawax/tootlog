@if(empty($status->reblog))
    <div class="bg-white border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm mb-2">
        <div class="flex gap-3 p-4">
            <div class="shrink-0">
                <a href="{{ $status->account->url }}" class="no-underline" target="_blank" rel="nofollow noopener">
                    <img class="rounded max-w-24"
                         src="{{ $status->account->avatar }}"
                         alt="{{ $status->name }}"
                         title="{{ $status->name }}">
                </a>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-semibold mb-1">
                    <a href="{{ $status->account->url }}" target="_blank"
                       rel="nofollow noopener" class="no-underline">{{ $status->name }} </a>
                    <small class="text-gray-500 font-normal">
                        {{ $status->acct }}
                        @if($status->account->locked)
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        @endif
                    </small>
                </h4>

                @if(empty($status->spoiler_text))
                    <div class="mb-3">
                        {!! $status->content !!}
                    </div>
                @else
                    <details class="mb-3">
                        <summary class="bg-yellow-400 text-black px-3 py-1 rounded cursor-pointer">
                            {{ $status->spoiler_text }}
                        </summary>
                        <div class="mt-2">
                            {!! $status->content !!}
                        </div>
                    </details>
                @endif

                <div class="text-sm text-gray-600">
                    <a href="{{ route('open.account.show', [
                        'user' => $status->account->user,
                        'username' => $status->account->username,
                        'domain' => $status->account->domain,
                        'status_id' => $status->status_id
                        ]) }}" class="no-underline pr-2">
                        <time title="{{ $status->local_datetime->toAtomString() }}"
                              datetime="{{ $status->local_datetime->toAtomString() }}">
                            {{ $status->local_datetime->diffForHumans() }}
                        </time>
                    </a>

                    <a href="{{ $status->url }}" target="_blank" rel="nofollow noopener">
                        <i class="fa fa-external-link" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        @include('status.footer')

    </div>
@else
    @include('status.reblog')
@endif
