<div class="panel panel-info">
    <div class="panel-heading">reblog at {{ $status->local_datetime }}</div>

    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <a href="{{ $status->reblog->account_url }}">
                    <img class="media-object img-rounded" src="{{ $status->reblog->avatar }}" alt="...">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><a href="{{ $status->reblog->account_url }}">{{ $status->reblog->display_name }}</a>
                <small>{{ $status->reblog->acct }}</small></h4>
                {!! $status->reblog->content !!}

                <div>
                    <a href="{{ $status->reblog->url }}" target="_blank">
                        {!! $status->reblog->created_at !!}
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
