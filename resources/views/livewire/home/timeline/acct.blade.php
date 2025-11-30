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

        $this->acct = Account::byAcct($this->username, $this->domain)->firstOrFail();
    }

    public function rendering(View $view): void
    {
        $view->title(__('Timeline'));
    }
}; ?>
<div id="app" class="flex">
    <div class="mr-6">
        <livewire:home.timeline.account_list/>
    </div>

    <div class="flex-1 px-3">
        <flux:heading size="xl" level="2" class="mb-4">
            <a href="{{ $acct->server->domain }}" target="_blank" rel="nofollow noopener">
                {{ $acct->acct }}
            </a>
        </flux:heading>

        <tt-user-timeline domain="{{ $acct->server->domain }}"
                          streaming="{{ $acct->server->streaming_url }}"
                          token="{{ $acct->token }}">
        </tt-user-timeline>
    </div>
</div>
