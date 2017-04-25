@extends('layouts.app')

@section('title', $user->name . '@' . config('app.name', 'tootlog'))


@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                {{ $statuses->links() }}

                @foreach($statuses as $status)
                    @include('status.item')
                @endforeach

                {{ $statuses->links() }}

            </div>

            @include('open.side')
        </div>
    </div>
@endsection
