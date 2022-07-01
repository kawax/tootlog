<div class="card">
    <div class="card-header bg-white">Export</div>

    <div class="card-body">
        <form method="POST" action="{{ route('export.csv') }}" accept-charset="UTF-8" class="form-horizontal">
            @csrf

            <input class="btn btn-primary" type="submit" value="CSV Export">

        </form>

        <div>
            @if (session('export'))
                {{ session('export') }}
            @else
                Send files by mail.
            @endif
        </div>
    </div>

</div>
