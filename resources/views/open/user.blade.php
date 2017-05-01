@extends('layouts.app')

@section('title', $user->name . '@' . config('app.name', 'tootlog'))

@if(!empty($statuses->first()->content))
    @section('description', strip_tags($statuses->first()->content))
@endif

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                <ol class="breadcrumb">
                    <li class="active">{{ '@' . $user->name  }}</li>
                </ol>

                <tt-calendar user="{{ $user->name }}"></tt-calendar>


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
