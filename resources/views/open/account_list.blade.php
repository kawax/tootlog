<div class="card mb-2">
    <div class="card-header bg-white"><a href="{{ route('open.user', $user) }}" class="text-decoration-none">{{ '@' . $user->name }} Account List</a>
    </div>

    <div class="card-body">
        <div class="list-group">
            @foreach($accounts as $account)
                <a href="{{ route('open.account.index', ['user' => $user->name ,'username' => $account->username, 'domain' => $account->domain]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                    @if($account->fails >= config('tootlog.account_fails'))
                        <i class="fa fa-ban fa-2x text-danger me-1" aria-hidden="true"></i>
                        <del>{{ $account->acct }}</del>
                    @else
                        <img src="{{ $account->favicon }}" width="{{ config('tootlog.favicon_size') }}"
                             class="rounded-circle me-1" alt="favicon">
                        {{ $account->acct }}
                    @endif

                    @if($account->locked)
                        <i class="fa fa-lock ms-1" aria-hidden="true"></i>
                    @endif

                    <span class="badge rounded-pill bg-secondary ms-auto">{{ $account->statuses_count }}</span>

                </a>
            @endforeach
        </div>
    </div>
</div>
