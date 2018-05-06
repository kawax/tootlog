@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row py-3 justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">User Preferences</div>
                    <div class="card-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('preferences.update') }}">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>

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

                            <div class="form-group row{{ $errors->has('theme') ? ' has-error' : '' }}">
                                <label for="theme" class="col-md-4 col-form-label">Font</label>

                                <div class="col-md-6">
                                    {{ Form::select('theme', [
                                    'thin' => 'Thin',
                                    'normal' => 'Normal'
                                    ], request()->user()->theme, ['class' => 'form-control']) }}

                                    @if ($errors->has('theme'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('theme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('special_key') ? ' has-error' : '' }}">
                                <label for="special_key" class="col-md-4 col-form-label">Special Key</label>

                                <div class="col-md-6">
                                    <input id="special_key" type="text"
                                           class="form-control" name="special_key"
                                           value="{{ request()->user()->special_key }}">
                                    <span class="text-muted">
                                        Get key from <a href="https://www.pixiv.net/fanbox/creator/762638" target="_blank" rel="noopener">pixiv FANBOX</a>.
                                    </span>

                                    @if ($errors->has('special_key'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('special_key') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">
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
