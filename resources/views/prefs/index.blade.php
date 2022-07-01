@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row py-3 justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">User Preferences</div>
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ route('preferences.update') }}">
                            @csrf

                            <div class="mb-3 row{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 col-form-label">E-Mail Address
                                    @if(request()->user()->hasVerifiedEmail())
                                        <span class="badge rounded-pill bg-success">Verified</span>
                                    @endif
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control" name="email"
                                           value="{{ request()->user()->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="mb-3 row{{ $errors->has('theme') ? ' has-error' : '' }}">
                                <label for="theme" class="col-md-4 col-form-label">Font</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="theme">
                                        <option value="thin"
                                                @if(request()->user()->theme === 'thin')selected="selected"@endif>Thin
                                        </option>
                                        <option value="normal"
                                                @if(request()->user()->theme === 'normal')selected="selected"@endif>
                                            Normal
                                        </option>
                                    </select>

                                    @if ($errors->has('theme'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('theme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
