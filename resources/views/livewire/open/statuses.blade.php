<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

/**
 * 公開。アカウントの投稿一覧。
 */

new class extends Component
{
    public Account $acct;
    public User $user;
    public string $username;
    public string $domain;

    public function mount(Request $request): void
    {
        $this->acct = Account::byAcct($this->username, $this->domain)->firstOrFail();

        if ($this->acct->locked) {
            $this->authorize('show', $this->acct);
        }
    }

    #[Computed]
    public function statuses()
    {
        return $this->acct->openStatuses(request()->query('search'))
            ->simplePaginate()
            ->appends(['search' => request()->query('search')]);
    }
}; ?>

<div>
    <div class="mb-3">
        {{ $this->statuses->links() }}
    </div>

    @foreach($this->statuses as $status)
        @include('status.item')
    @endforeach

    <div class="mt-3">
        {{ $this->statuses->links() }}
    </div>
</div>
