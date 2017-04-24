<div class="panel panel-info">
    <div class="panel-heading">reblogged at {{ $status->local_datetime->diffForHumans() }}</div>

    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <a href="{{ $status->reblog->account_url }}">
                    <img class="media-object img-rounded" src="{{ $status->reblog->avatar }}" alt="...">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><a href="{{ $status->reblog->account_url }}">{{ $status->reblog->name }}</a>
                <small>{{ $status->reblog->acct }}</small></h4>
                {!! $status->reblog->content !!}

                <div>
                    <a href="{{ $status->reblog->url }}" target="_blank">
                        <time datetime="{{ $status->reblog->created_at->toAtomString() }}">
                            {{ $status->reblog->created_at->diffForHumans() }}
                        </time>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
