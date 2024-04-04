<div class="card mb-3">
    <div class="card-header bg-white">
        Profile

        @can('delete', $acct)
            <button type="button"
                    class="btn btn-outline-danger btn-sm float-end"
                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                Delete...
            </button>
            @include('open.acct.delete')
        @endcan

    </div>
    <div class="card-body">

        <div class="d-flex">
            <div class="flex-shrink-0">
            <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener" class="text-decoration-none">
                <img class="rounded-circle toot-icon"
                     src="{{ $acct->avatar }}"
                     alt="{{ $acct->name }}"
                     title="{{ $acct->name }}">
            </a>
            </div>
            <div class="flex-grow-1 ms-3">
                <h3>{{ $acct->name }}</h3>
                <p>
                    <span class="badge rounded-pill bg-secondary">{{ $acct->statuses_count }} posts</span>
                    <span class="badge rounded-pill bg-secondary">{{ $acct->following_count }} follows</span>
                    <span class="badge rounded-pill bg-secondary">{{ $acct->followers_count }} followers</span>
                </p>

                <p>{!! $acct->note !!}</p>

                <a href="{{ $acct->url }}" target="_blank" rel="nofollow noopener" class="text-decoration-none">
                    {{ $acct->url }}
                </a>
            </div>
        </div>
    </div>
</div>
