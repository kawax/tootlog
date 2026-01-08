<?php

use App\Jobs\ExportCsvJob;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

new class extends Component
{
    public Collection $accounts;

    public User $user;

    public function mount(Request $request): void
    {
        $this->user = $request->user();

        $this->accounts = $this->user->allAccounts();
    }

    public function download(Account $account): StreamedResponse
    {
        $this->authorize('show', $account);

        return Storage::download("download/{$this->user->name}/{$account->acct}.csv");
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Download archives')" :subheading="__('After nearly 10 years of operation, the database size has reached its limit, so we have decided to delete the oldest data. Here, you can download the data from before the deletion started as a CSV file.')">
        @foreach($accounts as $account)
            <flux:button variant="ghost" icon="arrow-down-tray" wire:click="download({{ $account->id }})"
                         wire:key="{{ $account->id }}">
                {{ $account->acct }} [LastModified {{ Carbon::createFromTimestamp(Storage::lastModified("download/$user->name/$account->acct.csv"))->toDateString() }}]
            </flux:button>
        @endforeach

    </x-settings.layout>
</section>
