<div class="card mb-2">
    <div class="card-header bg-white">Search in {{ $search_in ?? '' }}</div>

    <div class="card-body">
        <form method="GET" action="{{ route($search_route, $search_param ?? null) }}" accept-charset="UTF-8"
              class="form-horizontal">
            <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
                <div class="input-group col-sm-12">
                    <input placeholder="Search..." class="form-control" name="search" type="search"
                           aria-describedby="search-button">

                    <input class="btn btn-primary" type="submit" value="Search" id="search-button">
                </div>
            </div>

        </form>
    </div>
</div>
