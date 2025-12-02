<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('welcome') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse">
        <x-app-logo/>
    </a>

    <flux:profile
        :name="request()->route('user')->name ?? 'No Name'"
        :initials="request()->route('user')->initials() ?? ''"
        :chevron="false"
    />

    @auth
        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Private')" class="grid">
                <flux:navlist.item icon="home" :href="route('home')"
                                   wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
    @endauth

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Public')" class="grid">
            <flux:navlist.item :href="route('open.user', request()->route('user'))"
                               :current="request()->routeIs('open.user')"
                               wire:navigate>{{ __('Statuses') }}</flux:navlist.item>

            <flux:navlist.item :href="route('open.archives', request()->route('user'))"
                               :current="request()->routeIs('open.archives')"
                               wire:navigate>{{ __('Archives') }}</flux:navlist.item>

        </flux:navlist.group>
    </flux:navlist>

    <livewire:open.account_list/>

    <livewire:open.recents/>

    <flux:spacer/>
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <flux:spacer/>
</flux:header>

{{ $slot }}

@fluxScripts
</body>
</html>
