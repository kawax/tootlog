@extends('layouts.app')

@section('title', $user->name . '@' . config('app.name', 'tootlog'))

@if(!empty($statuses->first()->content))
    @section('description', strip_tags($statuses->first()->content))
@endif

@section('open_graph')
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-md-last">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ '@' . $user->name  }}</li>
                    </ol>
                </nav>

                @include('home.search', [
                'search_route' => 'open.user',
                'search_param' => [$user],
                'search_in' => '@' . $user->name
                ])

                <tt-calendar user="{{ $user->name }}"></tt-calendar>

                {{ $statuses->appends(['search' => request('search')])->links() }}

                @foreach($statuses as $status)
                    @include('status.item')
                @endforeach

                {{ $statuses->appends(['search' => request('search')])->links() }}

            </div>

            @include('open.side')
        </div>
    </div>
@endsection
