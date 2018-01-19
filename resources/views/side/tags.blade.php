<div class="card">
    <div class="card-header bg-white"><a href="{{ route('tags.index', $user) }}">Tags</a></div>

    <div class="card-body">
        <div class="list-group">
            @foreach($tags as $tag)
                <a href="{{ route('tags.show', ['user' => $user->name ,'tag' => $tag]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    #{{ $tag->name }}

                    <span class="badge badge-pill badge-secondary ml-auto">{{ $tag->statuses_count }}</span>

                </a>
            @endforeach
        </div>
    </div>
</div>
