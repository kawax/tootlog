<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Volt\Component;

/**
 * 非公開。timeline用。認証した現在のユーザーのアカウント一覧を表示する。
 */

new class extends Component
{
    public Collection $accounts;

    public function mount(Request $request): void
    {
        $this->accounts = $request->user()->allAccounts();
    }
}; ?>

<flux:navlist variant="outline">
    <flux:navlist.group :heading="__('Timeline')" class="grid">
        @foreach($accounts as $account)
            <flux:navlist.item
                :href="route('home.timeline.acct', ['username' => $account->username, 'domain' => $account->domain])"
                :icon="$account->locked ? 'lock-closed' : ''"
                icon:variant="micro">
                @if($account->fails >= config('tootlog.account_fails'))
                    <del>{{ $account->acct }}</del>
                @else
                    {{ $account->acct }}
                @endif
            </flux:navlist.item>
        @endforeach
    </flux:navlist.group>
</flux:navlist>
