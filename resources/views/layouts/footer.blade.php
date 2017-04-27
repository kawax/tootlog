@inject('servers', 'App\Model\Server')

<footer class="footer">
    <div class="container text-center">
        <div class="text-muted">tootlog {{ config('tootlog.version') }}</div>
        <div><span class="badge">{{ $servers->count() }} instances</span></div>
        <div><a href="https://enty.jp/kawax" target="_blank">日本語での情報(Japanese Release Notes)</a></div>
    </div>
</footer>
