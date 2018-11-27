<div class="card mb-2">
    <div class="card-header bg-white">Search in {{ $search_in ?? '' }}</div>

    <div class="card-body">
        {{ Form::open(['route' => $search_route, 'class' => 'form-horizontal', 'method' => 'get']) }}

        <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
            <div class="input-group col-sm-12">
                {{ Form::text('search', request('search'), ['placeholder' => 'Search...', 'class' => 'form-control']) }}
                <div class="input-group-append">
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
