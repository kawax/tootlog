<div class="panel panel-default">
    <div class="panel-heading">Add Account</div>

    <div class="panel-body">
        {{ Form::open(['route' => 'accounts.add', 'class' => 'form-horizontal']) }}

        <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
            {{ Form::label('domain', 'URL', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('domain', 'https://chitose.moe', ['placeholder' => 'https://chitose.moe', 'class' => 'form-control']) }}
            </div>
        </div>

        {{ Form::submit('Add!', ['class' => 'btn btn-primary btn-block']) }}

        {{ Form::close() }}
    </div>
</div>
