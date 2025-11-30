<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component
{
    public ?Account $acct = null;
    public ?string $username = null;
    public ?string $domain = null;

    public function mount(Request $request): void
    {
        if ($request->has(['username', 'domain'])) {
            $this->username = $request->input('username');
            $this->domain = $request->input('domain');

            $this->acct = Account::byAcct($request->input('username'), $request->input('domain'))->first();
        }
    }

    #[Computed]
    public function statuses()
    {
        if (empty($this->acct)) {
            return auth()->user()->allStatuses(request()->query('search'))
                ->paginate()
                ->appends(['search' => request()->query('search')]);
        } else {
            return $this->acct->openStatuses(request()->query('search'))
                ->paginate()
                ->appends(['search' => request()->query('search')]);
        }
    }
}; ?>

<div>
    @foreach($this->statuses as $status)
        @include('status.item')
    @endforeach

    {{ $this->statuses->links() }}
</div>
