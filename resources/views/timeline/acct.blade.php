@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-8 col-md-push-4">
                <h2>
                    <a href="{{ $acct->server->domain }}" target="_blank" rel="nofollow noopener">
                        {{ $acct->acct }}
                    </a>
                </h2>

                <tt-user-timeline domain="{{ $acct->server->domain }}"
                                  streaming="{{ $acct->server->streaming }}"
                                  token="{{ $acct->token }}">
                </tt-user-timeline>
            </div>

            <div class="col-md-4 col-md-pull-8">
                @include('timeline.account_list')
            </div>
        </div>
    </div>
@endsection
