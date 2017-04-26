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
                        <a href="{{ $status->account->url }}" target="_blank" rel="nofollow noopener">{{ $status->name }}</a>
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
                        <button class="btn btn-warning btn-sm"
                                type="button"
                                data-toggle="collapse"
                                data-target="#cw_{{ $status->id }}"
                                aria-expanded="false"
                                aria-controls="collapse">
                            {{ $status->spoiler_text }}
                        </button>
                        <div class="collapse" id="cw_{{ $status->id }}">
                            {!! $status->content !!}
                        </div>
                    @endif

                    <div>
                        <a href="{{ $status->url }}" target="_blank" rel="nofollow noopener">
                            <time datetime="{{ $status->local_datetime->toAtomString() }}">
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
@else
    @include('status.reblog')
@endif
