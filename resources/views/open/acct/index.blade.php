@extends('layouts.app')

@section('title', $acct->acct . '@' . config('app.name', 'tootlog'))


@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">

                @include('open.acct.profile')

                {{ $statuses->links() }}

                @each('status.item', $statuses, 'status')

                {{ $statuses->links() }}

            </div>

            @include('open.side')

        </div>
    </div>
@endsection
