<div class="panel panel-default">
    <div class="panel-heading">Account List</div>

    <div class="panel-body">
        <ul class="list-group">
            @foreach($accounts as $account)
                <li class="list-group-item">
                    <span class="badge">{{ $account->statuses_count }}</span>
                    {{ $account->username . '@' }}{{ parse_url($account->url, PHP_URL_HOST) }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
