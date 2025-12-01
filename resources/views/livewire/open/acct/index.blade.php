<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

/**
 * 公開。指定したアカウントの投稿一覧を表示する。
 */

new
#[Layout('components.layouts.open')]
class extends Component
{
    public User $user;
    public string $username;
    public string $domain;
    public Account $acct;

    public function mount(Request $request): void
    {
        $this->acct = Account::byAcct($this->username, $this->domain)->firstOrFail();
    }

    public function rendering(View $view): void
    {
        $view->title($this->username.'@'.$this->domain);
    }
}; ?>

<div>
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('open.user', $user) }}">{{ '@'.$user->name }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $acct->acct }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @include('livewire.open.acct.profile')

    <livewire:open.statuses :username="$username" :domain="$domain"/>
</div>
