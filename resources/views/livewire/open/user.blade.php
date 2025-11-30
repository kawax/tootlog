<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\View\View;

/**
 * 公開。指定したユーザーの投稿を表示する。
 */

new
#[Layout('components.layouts.open')]
class extends Component
{
    public User $user;

    public function mount(Request $request, User $user): void
    {
        $this->user = $user;
    }

    public function rendering(View $view): void
    {
        $view->title($this->user->name);
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
    @foreach($this->statuses as $status)
        @include('status.item')
    @endforeach

    {{ $this->statuses->links() }}
</div>
