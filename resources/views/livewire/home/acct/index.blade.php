<?php

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
        }
    }

    public function rendering(View $view): void
    {
        $view->title(__('Dashboard'));
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
        </div>
    </div>
    <div class="relative h-full">
        <livewire:home.statuses :username="$username" :domain="$domain"/>
    </div>
</div>
