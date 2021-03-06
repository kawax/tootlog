<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input"
           id="customSwitch{{ $status->id }}"
           wire:click="toggle"
           @unless($status->trashed()) checked @endunless
    >
    <label class="custom-control-label text-muted"
           for="customSwitch{{ $status->id }}"
    >
        @unless($status->trashed()) Show @else Hide @endunless
    </label>
</div>
