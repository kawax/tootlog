@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-last">

                @include('home.public_url')

                @include('home.search', [
                'search_route' => 'home',
                'search_in' => 'Home'
                ])

                {{ $statuses->appends(['search' => request('search')])->links() }}

                @foreach($statuses as $status)
                    @include('status.item')
                @endforeach

                {{ $statuses->appends(['search' => request('search')])->links() }}

            </div>

            <div class="col-md-4 order-first">
                @include('home.side')
            </div>
        </div>
    </div>
@endsection
