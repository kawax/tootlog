<div class="panel panel-info">
    <div class="panel-heading">reblogged at {{ $status->local_datetime->diffForHumans() }}</div>

    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <a href="{{ $status->reblog->account_url }}" target="_blank" rel="nofollow noopener">
                    <img class="media-object img-rounded toot-icon"
                         src="{{ $status->reblog->avatar }}"
                         alt="{{ $status->reblog->name }}"
                         title="{{ $status->reblog->name }}">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="{{ $status->reblog->account_url }}" target="_blank" rel="nofollow noopener">{{ $status->reblog->name }}</a>
                    <small>{{ $status->reblog->acct }}</small>
                </h4>

                @if(empty($status->reblog->spoiler_text))
                    {!! $status->reblog->content !!}
                @else
                    <button class="btn btn-warning btn-sm"
                            type="button"
                            data-toggle="collapse"
                            data-target="#cw_{{ $status->id }}"
                            aria-expanded="false"
                            aria-controls="collapse">
                        {{ $status->reblog->spoiler_text }}
                    </button>
                    <div class="collapse" id="cw_{{ $status->id }}">
                        {!! $status->reblog->content !!}
                    </div>
                @endif

                <div>
                    <a href="{{ $status->reblog->url }}" target="_blank" rel="nofollow noopener">
                        <time datetime="{{ $status->reblog->created_at->toAtomString() }}">
                            {{ $status->reblog->created_at->diffForHumans() }}
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
