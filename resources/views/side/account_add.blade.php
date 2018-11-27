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
            <div class="input-group col-sm-9">
                {{ Form::text('domain', '', ['placeholder' => 'https://', 'class' => 'form-control']) }}
                <div class="input-group-append">
                    {{ Form::submit('Add', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
