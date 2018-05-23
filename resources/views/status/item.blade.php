@if(empty($status->reblog))
    <div class="card mb-2">
        <div class="card-body">

            <div class="media">
                <a href="{{ $status->account->url }}" target="_blank" rel="nofollow noopener">
                    <img class="rounded toot-icon"
                         src="{{ $status->account->avatar }}"
                         alt="{{ $status->name }}"
                         title="{{ $status->name }}">
                </a>
                <div class="media-body ml-3">
                    <h4>
                        <a href="{{ $status->account->url }}" target="_blank"
                           rel="nofollow noopener">{{ $status->name }} </a>
                        <small class="text-muted">
                            {{ $status->acct }}
                            @if($status->account->locked)
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            @endif
                        </small>
                    </h4>

                    @if(empty($status->spoiler_text))
                        {!! $status->content !!}
                    @else
                        <details>
                            <summary class="btn btn-warning">
                                {{ $status->spoiler_text }}
                            </summary>
                            {!! $status->content !!}
                        </details>
                    @endif

                    <div>
                        <a href="{{ route('open.account.show', [
                            'user' => $user,
                            'username' => $status->account->username,
                            'domain' => $status->account->domain,
                            'status_id' => $status->status_id
                            ]) }}">
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
        </div>

        @include('status.footer')

    </div>

    {!! $status->jsonLd() !!}

@else
    @include('status.reblog')
@endif
