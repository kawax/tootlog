<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Volt\Component;

new class extends Component
{
    public Collection $accounts;

    public User $user;

    public function mount(Request $request): void
    {
        $this->user = $request->user();

        $this->accounts = $this->user->allAccounts();
    }
}; ?>

<flux:navlist variant="outline">
    <flux:navlist.group :heading="__('Accounts')" class="grid">
        @foreach($accounts as $account)
            <flux:navlist.item
                :href="route('home.acct.index', ['username' => $account->username, 'domain' => $account->domain])"
                :current="request()->is(route('home.acct.index', ['username' => $account->username, 'domain' => $account->domain]))"
                badge="{{ $account->statuses_count }}"
                :icon="$account->locked ? 'lock-closed' : ''"
                wire:navigate>
                @if($account->fails >= config('tootlog.account_fails'))
                    <del>{{ $account->acct }}</del>
                @else
                    {{ $account->acct }}
                @endif
            </flux:navlist.item>
        @endforeach
    </flux:navlist.group>
</flux:navlist>
