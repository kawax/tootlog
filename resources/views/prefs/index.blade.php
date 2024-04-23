@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row py-3 justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">User Preferences</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('preferences.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end">E-Mail Address
                                    @if(request()->user()->hasVerifiedEmail())
                                        <span class="badge rounded-pill bg-success">Verified</span>
                                    @endif
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ request()->user()->email }}" required>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="mb-3 row{{ $errors->has('theme') ? ' has-error' : '' }}">
                                <label for="theme" class="col-md-4 col-form-label text-md-end">Font</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('theme') is-invalid @enderror" name="theme">
                                        <option value="thin"
                                                @if(request()->user()->theme === 'thin')selected="selected"@endif>Thin
                                        </option>
                                        <option value="normal"
                                                @if(request()->user()->theme === 'normal')selected="selected"@endif>
                                            Normal
                                        </option>
                                    </select>

                                    @error('theme')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('theme') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary px-3">
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
