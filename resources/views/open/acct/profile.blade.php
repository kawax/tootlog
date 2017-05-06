<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Profile</h3>
    </div>
    <div class="panel-body">

        <div class="media">
            <div class="media-left">
                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                    <img class="media-object img-rounded toot-icon"
                         src="{{ $acct->avatar }}"
                         alt="{{ $acct->name }}"
                         title="{{ $acct->name }}">
                </a>
            </div>
            <div class="media-body">
                <h3 class="media-heading">{!! EmojiOne::toImage($acct->name) !!}</h3>
                <p>
                    <span class="badge">{!! $acct->statuses_count !!} posts</span>
                    <span class="badge">{!! $acct->following_count !!} follows</span>
                    <span class="badge">{!! $acct->followers_count !!} followers</span>
                </p>

                <p>{!! EmojiOne::toImage($acct->note) !!}</p>

                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
{!! $acct->jsonLd() !!}
