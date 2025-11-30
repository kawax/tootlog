<?php

use App\Models\Account;
use App\Models\Status;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\View\View;
use Illuminate\Http\Request;

/**
 * 公開。指定したアカウントの個別投稿を表示する。
 */

new
#[Layout('components.layouts.open')]
class extends Component
{
    public Status $status;
    public User $user;
    public Account $acct;
    public string $username;
    public string $domain;
    public string $status_id;

    public function mount(Request $request): void
    {
        $this->user = $request->user();

        $this->acct = Account::byAcct($this->username, $this->domain)->firstOrFail();

        $this->status = $this->acct->status($this->status_id);

        if ($this->acct->locked || $this->status->trashed()) {
            $this->authorize('show', $this->acct);
        }
    }

    public function rendering(View $view): void
    {
        $view->title($this->username.'@'.$this->domain);
    }
}; ?>

<div>
    @include('livewire.open.acct.profile')

    @include('status.item')
</div>
