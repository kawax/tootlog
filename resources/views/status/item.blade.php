@if(empty($status->reblog))
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="{{ $status->account->url }}">
                        <img class="media-object img-rounded toot-icon" src="{{ $status->account->avatar }}" alt="{{ $status->name }}">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="{{ $status->account->url }}">{{ $status->name }}</a>
                        <small class="text-muted">{{ $status->acct }}</small>
                    </h4>

                    {!! $status->content !!}

                    <div>
                        <a href="{{ $status->url }}" target="_blank">
                            <time datetime="{{ $status->local_datetime->toAtomString() }}">
                                {{ $status->local_datetime->diffForHumans() }}
                            </time>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@else
    @include('status.reblog')
@endif
