@if (session('message'))
    <div class="alert alert-danger" role="alert">
        {{ session('message') }}
    </div>
@endif

<div class="card mb-2">
    <div class="card-header bg-white">Add Account</div>

    <div class="card-body">
        <form method="POST" action="{{ route('accounts.add') }}" accept-charset="UTF-8" class="form-horizontal">
            @csrf

            <div class="form-group row{{ $errors->has('domain') ? ' has-error' : '' }}">
                <label for="domain" class="col-sm-3 col-form-label">URL</label>
                <div class="input-group col-sm-9">
                    <input placeholder="https://" class="form-control" name="domain" type="text" value="" id="domain"
                           aria-describedby="add-button">
                    <input class="btn btn-primary" type="submit" value="Add" id="add-button">
                </div>
            </div>

        </form>
    </div>
</div>
