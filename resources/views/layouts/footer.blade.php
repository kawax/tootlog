<footer class="bg-white border-top mb-5">
    <div class="container text-center">
        <div class="text-muted">tootlog {{ config('tootlog.version') }}</div>

        <livewire:footer-info lazy></livewire:footer-info>

        <div>
            <a href="https://github.com/kawax/tootlog" target="_blank" rel="noopener noreferrer">GitHub</a> |
            <a href="{{ url('/usage') }}">使い方</a> |
            <a href="{{ url('/usage-en') }}">How to Use</a> |
        </div>
    </div>
</footer>
