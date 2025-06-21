<footer class="bg-white border-top mb-5">
    <div class="container text-center">
        <div class="text-muted my-3">tootlog {{ config('tootlog.version') }}</div>

        <livewire:footer-info lazy></livewire:footer-info>

        <div class="my-3">
            <a href="https://github.com/kawax/tootlog" target="_blank">GitHub</a> |
            <a href="{{ route('usage.jp') }}">使い方</a> |
            <a href="{{ route('usage.en') }}">How to Use</a>
        </div>
    </div>
</footer>
