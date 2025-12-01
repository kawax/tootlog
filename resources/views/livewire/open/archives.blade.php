<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\View\View;

/**
 * 公開。指定したユーザーの月別アーカイブリストページを表示する。
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
        $view->title('@'.$this->user->name.' - '.__('Archives'));
    }

    #[Computed]
    public function archives()
    {
        return $this->user->openArchives();
    }
}; ?>

<div>
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('open.user', $user) }}">{{ '@'.$user->name }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Archives') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:heading size="xl">{{ __('Archives') }}</flux:heading>
    <flux:text class="mt-2 mb-6">{{ __('Monthly Archive List') }}</flux:text>

    <flux:navlist variant="outline" class="w-64">
        @foreach($this->archives as $date => $archive)
            <flux:navlist.item
                href="{{ route('open.user.date.day', [
                        'user' => $user->name ,
                        'year' => explode('-', $date)[0],
                        'month' => explode('-', $date)[1]]) }}"
                badge="{{ $archive }}"
                icon="calendar-days">
                {{ $date }}
            </flux:navlist.item>
        @endforeach
    </flux:navlist>
</div>
