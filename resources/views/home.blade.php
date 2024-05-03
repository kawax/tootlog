@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-md-last">

                @include('home.public_url')

                @include('home.search', [
                'search_route' => 'home',
                'search_in' => 'Home'
                ])

                {{ $statuses->links() }}

                @foreach($statuses as $status)
                    @include('status.item')
                @endforeach

                {{ $statuses->links() }}

            </div>

            <div class="col-md-4 order-md-first">
                @include('home.side')
            </div>
        </div>
    </div>
@endsection
