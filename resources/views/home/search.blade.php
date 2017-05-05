<div class="panel panel-default">
    <div class="panel-heading">Search in {{ $search_in or '' }}</div>

    <div class="panel-body">
        {{ Form::open(['route' => $search_route, 'class' => 'form-horizontal', 'method' => 'get']) }}

        <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
            <div class="col-sm-12">
                {{ Form::text('search', request('search'), ['placeholder' => 'Search...', 'class' => 'form-control']) }}
            </div>
        </div>

        {{ Form::submit('Search', ['class' => 'btn btn-primary btn-block']) }}

        {{ Form::close() }}
    </div>
</div>
