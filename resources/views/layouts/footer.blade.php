<footer class="bg-white border-top">
    <div class="container text-center">
        <div class="text-muted">tootlog {{ config('tootlog.version') }}</div>
        <div>
            <span class="badge badge-pill badge-secondary">{{ $footer_servers }} instances</span>
            <span class="badge badge-pill badge-secondary">{{ $footer_accounts }} accounts</span>
            <span class="badge badge-pill badge-secondary">{{ $footer_statuses }} statuses</span>
        </div>
        <div>
            <a href="https://github.com/kawax/tootlog" target="_blank" rel="noopener">GitHub</a>
            <a href="{{ url('/usage') }}">使い方</a>
        </div>
    </div>
</footer>
