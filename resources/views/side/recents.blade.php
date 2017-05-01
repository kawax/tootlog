<div class="panel panel-default">
    <div class="panel-heading">Recent</div>

    <div class="panel-body">
        <div class="list-group">
            @foreach($recents as $date => $recent)
                <a href="{{ route('open.user.date', ['user' => $user->name ,'date' => $date]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $recent->count() }}</span>

                    {{ $date }}

                </a>
            @endforeach
        </div>
    </div>
</div>
