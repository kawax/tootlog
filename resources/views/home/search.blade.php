<div class="card mb-2">
    <div class="card-header bg-white">Search in {{ $search_in or '' }}</div>

    <div class="card-body">
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
