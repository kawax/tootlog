@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Preferences</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('preferences.update') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

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

                            <div class="form-group{{ $errors->has('theme') ? ' has-error' : '' }}">
                                <label for="theme" class="col-md-4 control-label">Font</label>

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

                            <div class="form-group{{ $errors->has('special_key') ? ' has-error' : '' }}">
                                <label for="special_key" class="col-md-4 control-label">Special Key</label>

                                <div class="col-md-6">
                                    <input id="special_key" type="text"
                                           class="form-control" name="special_key"
                                           value="{{ request()->user()->special_key }}">
                                    <span class="help-block">
                                        Get key from <a href="https://enty.jp/kawax" target="_blank">Enty</a> or <a
                                                href="https://fantia.jp/kawax" target="_blank">fantia</a>(Japanese). <a href="https://enty.jp/en/kawax" target="_blank">Enty(English)</a>
                                    </span>

                                    @if ($errors->has('special_key'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('special_key') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
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
