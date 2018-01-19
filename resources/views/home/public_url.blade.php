<div class="card mb-2">
    <div class="card-header bg-white">
        Public URL
    </div>
    <div class="card-body">
        <a href="{{ route('open.user', auth()->user()) }}">
            {{ route('open.user', auth()->user()) }}
        </a>
    </div>
</div>
