<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Volt\Component;
use Illuminate\Http\Request;

/**
 * timeline.acctへリダイレクト
 */
new class extends Component
{
    public function mount(Request $request): void
    {
        $accounts = $request->user()->allAccounts();

        if ($accounts->count() > 0) {
            $acct = $accounts->first();
            $this->redirect(route('home.timeline.acct', ['username' => $acct->username, 'domain' => $acct->domain]));
        }
    }
}; ?>
