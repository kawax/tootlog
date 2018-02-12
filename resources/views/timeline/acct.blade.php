@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-8 order-md-last">
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

            <div class="col-md-4 order-md-first">
                @include('timeline.account_list')
            </div>
        </div>
    </div>
@endsection
