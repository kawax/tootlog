<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Volt\Component;
use Illuminate\Http\Request;

/**
 * 非公開。Vueコンポーネントでリアルタイムのタイムラインを表示する。
 */

new class extends Component
{
    public Account $acct;
    public User $user;
    public string $username;
    public string $domain;

    public function mount(Request $request): void
    {
        $this->user = $request->user();

        $this->acct = Account::byAcct($this->username, $this->domain)
            ->with('server')->firstOrFail();
    }

    public function rendering(View $view): void
    {
        $view->title(__('Timeline'));
    }
}; ?>
<div id="app" class="flex">
    <div class="order-2 flex-1 px-3">
        <h2>
            <a href="{{ $acct->server->domain }}" target="_blank" rel="nofollow noopener"
               class="text-decoration-none">
                {{ $acct->acct }}
            </a>
        </h2>

        <tt-user-timeline domain="{{ $acct->server->domain }}"
                          streaming="{{ $acct->server->streaming }}"
                          token="{{ $acct->token }}">
        </tt-user-timeline>
    </div>

    <div class="order-1 mr-6">
        <livewire:home.timeline.account_list/>
    </div>
</div>
