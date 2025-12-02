<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\View\View;
use Illuminate\Http\Request;

/**
 * 公開。指定したユーザーの投稿を表示する。
 */

new
#[Layout('components.layouts.open')]
class extends Component
{
    public User $user;

    public function mount(Request $request): void
    {
        $this->user = $request->route('user');
    }

    public function rendering(View $view): void
    {
        $view->title('@'.$this->user->name.' - '.__('Statuses'));
    }

    #[Computed]
    public function statuses()
    {
        return $this->user->openStatuses(request()->query('search'))
            ->simplePaginate()
            ->appends(['search' => request()->query('search')]);
    }
}; ?>

<div>
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('open.user', $user) }}">{{ '@'.$user->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

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
