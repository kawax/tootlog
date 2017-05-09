@inject('footer_servers', 'App\Model\Server')
@inject('footer_statuses', 'App\Model\Status')

<footer class="footer">
    <div class="container text-center">
        <div class="text-muted">tootlog {{ config('tootlog.version') }}</div>
        <div>
            <span class="badge">{{ $footer_servers->count() }} instances</span>
            <span class="badge">{{ $footer_statuses->count() }} statuses</span>
        </div>
        <div><a href="https://enty.jp/kawax" target="_blank">日本語情報(Japanese Release Notes)</a></div>
    </div>
</footer>
