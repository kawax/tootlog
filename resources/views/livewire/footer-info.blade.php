<div wire:init="loadInfo">
    <div>
    <span class="badge badge-pill badge-secondary">
        <a href="{{ route('instances') }}" class="text-white">
            {{ $footer_servers }} instances
        </a>
    </span>
        <span class="badge badge-pill badge-secondary">{{ $footer_accounts }} accounts</span>
        <span class="badge badge-pill badge-secondary">{{ $footer_statuses }} statuses</span>
    </div>
</div>
