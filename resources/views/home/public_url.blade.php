<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Public URL</h3>
    </div>
    <div class="panel-body">
        <a href="{{ route('open.user', auth()->user()) }}">
            {{ route('open.user', auth()->user()) }}
        </a>
    </div>
</div>
