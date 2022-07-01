<div class="form-check form-switch">
    <input type="checkbox"
           role="switch"
           class="form-check-input"
           id="SwitchCheck{{ $status->id }}"
           wire:click="toggle"
           @checked(! $status->trashed())
    >
    <label class="form-check-label text-muted"
           for="SwitchCheck{{ $status->id }}"
    >
        @unless($status->trashed()) Show @else Hide @endunless
    </label>
</div>
