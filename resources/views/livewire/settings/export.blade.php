<?php

use App\Jobs\ExportCsvJob;
use Livewire\Volt\Component;

new class extends Component
{
    public function export(): void
    {
        ExportCsvJob::dispatch(auth()->user());

        $this->dispatch('export-dispatched');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Export')" :subheading="__('Send the CSV file by email')">
        <flux:button variant="primary" type="submit" wire:click="export">
            {{ __('Export') }}
        </flux:button>

        <x-action-message class="me-3" on="export-dispatched">
            {{ __('Export has started. Please wait for an email.') }}
        </x-action-message>
    </x-settings.layout>
</section>
