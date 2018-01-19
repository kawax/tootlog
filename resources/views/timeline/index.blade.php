@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @if($accounts->count() > 0)

                <div class="col-md-8 order-2">
                    <h2>
                        <a href="{{ $accounts->first()->server->domain }}" target="_blank" rel="nofollow noopener">
                            {{ $accounts->first()->acct }}
                        </a>
                    </h2>

                    <tt-user-timeline domain="{{ $accounts->first()->server->domain }}"
                                      streaming="{{ $accounts->first()->server->streaming }}"
                                      token="{{ $accounts->first()->token }}">
                    </tt-user-timeline>
                </div>

                <div class="col-md-4 order-1">
                    @include('timeline.account_list')
                </div>
            @endif

        </div>
    </div>
@endsection
