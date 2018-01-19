@if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif

<div class="card mb-2">
    <div class="card-header bg-white">Add Account</div>

    <div class="card-body">
        {{ Form::open(['route' => 'accounts.add', 'class' => 'form-horizontal']) }}

        <div class="form-group row{{ $errors->has('domain') ? ' has-error' : '' }}">
            {{ Form::label('domain', 'URL', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('domain', '', ['placeholder' => 'https://chitose.moe', 'class' => 'form-control']) }}
            </div>
        </div>

        {{ Form::submit('Add!', ['class' => 'btn btn-primary btn-block']) }}

        {{ Form::close() }}
    </div>
</div>
