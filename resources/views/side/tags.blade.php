<div class="panel panel-default">
    <div class="panel-heading"><a href="{{ route('tags.index', $user) }}">Tags</a></div>

    <div class="panel-body">
        <div class="list-group">
            @foreach($tags as $tag)
                <a href="{{ route('tags.show', ['user' => $user->name ,'tag' => $tag]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $tag->statuses_count }}</span>
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>
