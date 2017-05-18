@if(empty($status->reblog))
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="media">
                <div class="media-left">
                    <a href="{{ $status->account->url }}" target="_blank" rel="nofollow noopener">
                        <img class="media-object img-rounded toot-icon"
                             src="{{ $status->account->avatar }}"
                             alt="{{ $status->name }}"
                             title="{{ $status->name }}">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="{{ $status->account->url }}" target="_blank"
                           rel="nofollow noopener">{!! EmojiOne::toImage($status->name) !!} </a>
                        <small class="text-muted">
                            {{ $status->acct }}
                            @if($status->account->locked)
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            @endif
                        </small>
                    </h4>

                    @if(empty($status->spoiler_text))
                        {!! EmojiOne::toImage($status->content) !!}
                    @else
                        <details>
                            <summary class="btn btn-warning">{!! EmojiOne::toImage($status->spoiler_text) !!}</summary>
                            {!! EmojiOne::toImage($status->content) !!}
                        </details>
                    @endif

                    <div>
                        <a href="{{ $status->url }}" target="_blank" rel="nofollow noopener">
                            <time title="{{ $status->local_datetime->toAtomString() }}" datetime="{{ $status->local_datetime->toAtomString() }}">
                                {{ $status->local_datetime->diffForHumans() }}
                            </time>
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('open.account.show', [
                            'user' => $user,
                            'username' => $status->account->username,
                            'domain' => $status->account->domain,
                            'status_id' => $status->status_id
                            ]) }}">
                            {{ $status->account->acct . '/' . $status->status_id }}

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
