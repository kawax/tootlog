<div class="card">
    <div class="card-header bg-white">Export</div>

    <div class="card-body">
        {{ Form::open(['route' => 'export.csv', 'class' => 'form-horizontal']) }}

        {{ Form::submit('CSV Export', ['class' => 'btn btn-primary btn-block']) }}

        {{ Form::close() }}

        <div>
            @if (session('export'))
                {{ session('export') }}
            @else
                Send files by mail.
            @endif
        </div>
    </div>

</div>
