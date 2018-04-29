<div class="card mb-2">
    <div class="card-header bg-white"><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name }} Account List</a></div>

    <div class="card-body">
        <div class="list-group">
            @foreach($accounts as $account)
                <a href="{{ route('open.account.index', ['user' => $user->name ,'username' => $account->username, 'domain' => $account->domain]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">


                    @if($account->fails >= config('tootlog.account_fails'))
                        <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                    @else
                        <img src="{{ $account->favicon }}" width="{{ config('tootlog.favicon_size') }}"
                             class="rounded-circle mr-1" alt="favicon">
                    @endif

                    {{ $account->acct }}

                    @if($account->locked)
                        <i class="fa fa-lock ml-1" aria-hidden="true"></i>
                    @endif

                    <span class="badge badge-pill badge-secondary ml-auto">{{ $account->statuses_count }}</span>

                </a>
            @endforeach
        </div>
    </div>
</div>
