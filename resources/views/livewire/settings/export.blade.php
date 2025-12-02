<?php

use App\Jobs\ExportCsvJob;
use Livewire\Volt\Component;

new class extends Component
{
    public function export(): void
    {
        ExportCsvJob::dispatch(auth()->user());

        session()->flash('message', 'Export has started. Please wait for an email.');

        $this->redirect(route('home'));
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Export')" :subheading="__('Send the CSV file by email')">
        <flux:button variant="primary" type="submit" wire:click="export">
            {{ __('Export') }}
        </flux:button>
    </x-settings.layout>
</section>
