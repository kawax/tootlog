<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Profile</h3>
    </div>
    <div class="panel-body">

        <div class="media">
            <div class="media-left">
                <a href="{{ $acct->url }}" target="_blank">
                    <img class="media-object img-rounded toot-icon"
                         src="{{ $acct->avatar }}"
                         alt="{{ $acct->username }}"
                         title="{{ $acct->username }}">
                </a>
            </div>
            <div class="media-body">
                <h3 class="media-heading">{{ empty($acct->display_name) ? $acct->username : $acct->display_name }}</h3>
                <p>{!! $acct->note !!}</p>

                <a href="{{ $acct->url }}" target="_blank">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
