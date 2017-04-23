@if(empty($status->reblog))
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="{{ $status->account->url }}">
                        <img class="media-object img-rounded" src="{{ $status->account->avatar }}" alt="...">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a href="{{ $status->account->url }}">{{ $status->account->acct }}</a>
                        <small class="text-muted">{{ $status->acct }}</small>
                    </h4>
                    {!! $status->content !!}

                    <div>
                        <a href="{{ $status->url }}" target="_blank">
                            {!! $status->local_datetime !!}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@else
    @include('status.reblog')
@endif
