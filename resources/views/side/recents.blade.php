<div class="card mb-2">
    <div class="card-header bg-white">Recent</div>

    <div class="card-body">
        <div class="list-group">
            @foreach($recents as $date => $recent)
                <a href="{{ route('open.user.date.day', [
                'user' => $user->name ,
                'year' => explode('-', $date)[0],
                'month' => explode('-', $date)[1],
                'day' => explode('-', $date)[2]]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <i class="fa fa-calendar-o me-1" aria-hidden="true"></i>
                    {{ $date }}
                    <span class="badge rounded-pill bg-secondary ms-auto">{{ $recent }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('open.archives', $user) }}">Archives</a>
    </div>

</div>
