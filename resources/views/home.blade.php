@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Public URL</h3>
                    </div>
                    <div class="panel-body">
                        <a href="{{ route('open.user', auth()->user()) }}" target="_blank">
                            {{ route('open.user', auth()->user()) }}
                        </a>
                    </div>
                </div>

                {{ $statuses->links() }}

                @each('status.item', $statuses, 'status')

                {{ $statuses->links() }}

            </div>


            <div class="col-md-4 col-md-pull-8">
                @include('side.account_add')
                @include('side.account_list')
            </div>
        </div>
    </div>
@endsection
