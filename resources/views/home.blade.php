@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">

                @include('home.public_url')

                @include('home.search')

                {{ $statuses->appends(['search' => request('search')])->links() }}

                @foreach($statuses as $status)
                    @include('status.item')
                @endforeach

                {{ $statuses->appends(['search' => request('search')])->links() }}

            </div>

            <div class="col-md-4 col-md-pull-8">
                @include('home.side')
            </div>
        </div>
    </div>
@endsection
