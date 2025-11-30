<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Livewire\Volt\Component;

/**
 * 非公開。認証した現在のユーザーの最近の投稿日一覧を表示する。
 */

new class extends Component
{
    public Collection $recents;

    public User $user;

    public function mount(Request $request): void
    {
        $this->user = $request->user();

        $this->recents = $this->user->openRecents();
    }
}; ?>

<flux:navlist variant="outline">
    <flux:navlist.group :heading="__('Recents')" class="grid">
        @foreach($recents as $date => $recent)
            <flux:navlist.item
                :href="route('open.user.date.day', [
                'user' => $user->name ,
                'year' => explode('-', $date)[0],
                'month' => explode('-', $date)[1],
                'day' => explode('-', $date)[2]])"
                badge="{{ $recent }}"
                icon="eye"
                wire:navigate>
                {{ $date }}
            </flux:navlist.item>
        @endforeach
    </flux:navlist.group>
</flux:navlist>
