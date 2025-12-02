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

    @if(session('message'))
        <div
            x-data="{ shown: false, timeout: null }"
            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 5000);"
            x-show.transition.out.opacity.duration.1500ms="shown"
            x-transition:leave.opacity.duration.1500ms
            class="fixed top-0 right-0 w-auto m-4 px-4 py-2 bg-sky-100 border border-sky-300 text-sky-800 rounded-lg shadow-md">
            {{ session('message') }}
        </div>
    @endif
</div>
