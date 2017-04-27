@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-8 col-md-push-4">

                <h2>
                    <a href="{{ $accounts->first()->url }}" target="_blank" rel="nofollow noopener">
                        {{ $accounts->first()->acct }}
                    </a>
                </h2>

                <tt-user-timeline domain="{{ $accounts->first()->server->domain }}"
                                  streaming="{{ $accounts->first()->server->streaming }}"
                                  token="{{ $accounts->first()->token }}">
                </tt-user-timeline>
            </div>

            <div class="col-md-4 col-md-pull-8">
                @include('timeline.account_list')
            </div>
        </div>
    </div>
@endsection
