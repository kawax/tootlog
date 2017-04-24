@extends('layouts.app')

@section('title', $user->name . '@' . config('app.name', 'tootlog'))


@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                {{ $statuses->links() }}

                @each('status.item', $statuses, 'status')

                {{ $statuses->links() }}

            </div>

            <div class="col-md-4 col-md-pull-8">
                @include('side.account_list')
            </div>
        </div>
    </div>
@endsection
