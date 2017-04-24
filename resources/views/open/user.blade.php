@extends('layouts.app')

@section('title', $user->name . '@' . config('app.name', 'tootlog'))


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                @include('side.account_list')
            </div>

            <div class="col-md-8">
                {{ $statuses->links() }}

                @each('status.item', $statuses, 'status')

                {{ $statuses->links() }}

            </div>
        </div>
    </div>
@endsection
