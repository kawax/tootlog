<div class="card mb-3">
    <div class="card-header bg-white">
        <h3 class="card-title">Profile</h3>
    </div>
    <div class="card-body">

        <div class="media">
            <div class="media-left">
                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                    <img class="media-object rounded-circle toot-icon"
                         src="{{ $acct->avatar }}"
                         alt="{{ $acct->name }}"
                         title="{{ $acct->name }}">
                </a>
            </div>
            <div class="media-body">
                <h3 class="media-heading">{!! LaravelEmojiOne::toImage($acct->name) !!}</h3>
                <p>
                    <span class="badge badge-pill badge-secondary">{!! $acct->statuses_count !!} posts</span>
                    <span class="badge badge-pill badge-secondary">{!! $acct->following_count !!} follows</span>
                    <span class="badge badge-pill badge-secondary">{!! $acct->followers_count !!} followers</span>
                </p>

                <p>{!! LaravelEmojiOne::toImage($acct->note) !!}</p>

                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
{!! $acct->jsonLd() !!}
