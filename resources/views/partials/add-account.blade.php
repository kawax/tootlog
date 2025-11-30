<div class="p-6 w-full">
    <flux:heading size="lg" level="3">{{ __('Add Account') }}</flux:heading>
    <flux:subheading size="md">
        {{ __('Enter your Mastodon server URL to add a new account') }}
    </flux:subheading>

    <form method="POST" action="{{ route('accounts.add') }}" accept-charset="UTF-8">
        @csrf
        <flux:field>
            <flux:input.group>
                <flux:input name="domain" value="{{ old('domain') }}" placeholder="https://"/>
                <flux:button type="submit" icon="plus">Add</flux:button>
            </flux:input.group>
            <flux:error name="domain"/>
        </flux:field>
    </form>
</div>
