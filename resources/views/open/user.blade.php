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

            <div class="col-md-8 col-md-push-4">
                <ol class="breadcrumb">
                    <li class="active">{{ '@' . $user->name  }}</li>
                </ol>

                @include('home.search', [
                'search_route' => ['open.user', $user],
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
