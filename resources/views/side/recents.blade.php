<div class="panel panel-default">
    <div class="panel-heading">Recent</div>

    <div class="panel-body">
        <div class="list-group">
            @foreach($recents as $date => $recent)
                <a href="{{ route('open.user.date.day', [
                'user' => $user->name ,
                'year' => explode('-', $date)[0],
                'month' => explode('-', $date)[1],
                'day' => explode('-', $date)[2]]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $recent->count() }}</span>
                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                    {{ $date }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="panel-footer">
        <a href="{{ route('open.archives', $user) }}">Archives</a>
    </div>

</div>
