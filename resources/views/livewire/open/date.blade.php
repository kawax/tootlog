<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\View\View;

/**
 * 公開。指定したユーザーの投稿を日付で絞り込んで表示する。
 */

new
#[Layout('components.layouts.open')]
class extends Component
{
    public User $user;
    public ?string $year = null;
    public ?string $month = null;
    public ?string $day = null;

    public function mount(Request $request, User $user, ?string $year = null, ?string $month = null, ?string $day = null): void
    {
        if (empty($year)) {
            $this->redirect(route('open.user', $user));
        }

        $this->user = $user;
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function rendering(View $view): void
    {
        $view->title($this->user->name.' - '.Carbon::createFromDate($this->year, $this->month, $this->day)->toDateString());
    }

    #[Computed]
    public function statuses()
    {
        return $this->user->openStatusesByDate($this->year, $this->month, $this->day)->simplePaginate();
    }
}; ?>

<div>
    @foreach($this->statuses as $status)
        @include('status.item')
    @endforeach

    {{ $this->statuses->links() }}
</div>
