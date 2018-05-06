<footer class="bg-white border-top">
    <div class="container text-center">
        <div class="text-muted">tootlog {{ config('tootlog.version') }}</div>
        <div>
            <span class="badge badge-pill badge-secondary">
                <a href="{{ route('instances') }}" class="text-white">
                    {{ $footer_servers }} instances
                </a>
            </span>
            <span class="badge badge-pill badge-secondary">{{ $footer_accounts }} accounts</span>
            <span class="badge badge-pill badge-secondary">{{ $footer_statuses }} statuses</span>
        </div>
        <div>
            <a href="https://github.com/kawax/tootlog" target="_blank" rel="noopener">GitHub</a> |
            <a href="{{ url('/usage') }}">使い方</a> |
            <a href="https://www.pixiv.net/fanbox/creator/762638" target="_blank" rel="noopener">pixivFANBOX</a>
        </div>
    </div>
</footer>
