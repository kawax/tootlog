<div class="p-6 w-full">
    <flux:heading size="lg" level="3">{{ __('Public URL') }}</flux:heading>
    <flux:subheading size="md" class="mb-3">{{ __('Current URL is only visible to you. Please use the following for public URL') }}</flux:subheading>
    <a href="{{ route('open.user', auth()->user()) }}" class="text-md">
        {{ route('open.user', auth()->user()) }}
    </a>
</div>
