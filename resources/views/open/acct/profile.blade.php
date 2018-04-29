<div class="card mb-3">
    <div class="card-header bg-white">
        Profile
    </div>
    <div class="card-body">

        <div class="media">
            <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                <img class="rounded-circle toot-icon"
                     src="{{ $acct->avatar }}"
                     alt="{{ $acct->name }}"
                     title="{{ $acct->name }}">
            </a>
            <div class="media-body ml-3">
                <h3>{!! $acct->name !!}</h3>
                <p>
                    <span class="badge badge-pill badge-secondary">{!! $acct->statuses_count !!} posts</span>
                    <span class="badge badge-pill badge-secondary">{!! $acct->following_count !!} follows</span>
                    <span class="badge badge-pill badge-secondary">{!! $acct->followers_count !!} followers</span>
                </p>

                <p>{!! $acct->note !!}</p>

                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
{!! $acct->jsonLd() !!}
