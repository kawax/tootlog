<?php

use Illuminate\View\View;
use Livewire\Volt\Component;

/**
 * 非公開。ダッシュボードのホーム画面。
 */

new class extends Component
{
    public function rendering(View $view): void
    {
        $view->title(config('app.name'));
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @include('partials.public-url')
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @include('partials.add-account')
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @include('partials.stats')
        </div>
    </div>
    <div class="relative h-full">
        <livewire:home.statuses/>
    </div>
</div>
