<div class="panel panel-default">
    <div class="panel-heading"><a href="{{ route('open.user', $user) }}">Account List</a></div>

    <div class="panel-body">
        <div class="list-group">
            @foreach($accounts as $account)
                <a href="{{ route('open.account.index', ['user' => $user->name ,'username' => $account->username, 'domain' => $account->domain]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $account->statuses_count }}</span>
                    {{ $account->acct }}
                </a>
            @endforeach
        </div>
    </div>
</div>
