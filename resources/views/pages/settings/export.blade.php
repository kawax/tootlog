<?php

use App\Jobs\ExportCsvJob;
use Livewire\Component;
use Flux\Flux;

new class extends Component
{
    public function export(): void
    {
        ExportCsvJob::dispatch(auth()->user());

        Flux::toast(
            text: __('Please wait for an email.'),
            heading: __('Export has started'),
            variant: 'success'
        );

        $this->redirect(route('home'), navigate: true);
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Export')" :subheading="__('Send the CSV file by email')">
        <flux:button variant="primary" type="submit" wire:click="export">
            {{ __('Export') }}
        </flux:button>
    </x-pages::settings.layout>
</section>
