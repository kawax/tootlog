<div class="panel panel-default">
    <div class="panel-heading"><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name }} Account List</a></div>

    <div class="panel-body">
        <div class="list-group">
            @foreach($accounts as $account)
                <a href="{{ route('open.account.index', ['user' => $user->name ,'username' => $account->username, 'domain' => $account->domain]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $account->statuses_count }}</span>
                    @if($account->fails >= config('tootlog.account_fails'))
                        <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                    @endif
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    {{ $account->acct }}
                    @if($account->locked)
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    @endif

                </a>
            @endforeach
        </div>
    </div>
</div>
