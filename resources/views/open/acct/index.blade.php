@extends('layouts.app')

@section('title', $acct->acct . ' - ' . config('app.name', 'tootlog'))

@section('description', strip_tags($acct->note))

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">

                <ol class="breadcrumb">
                    <li><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                    <li class="active">{{ $acct->acct  }}</li>
                </ol>

                @include('open.acct.profile')

                @include('open.acct.search')


                <tt-calendar user="{{ $user->name }}" acct="{{ $acct->acct }}"></tt-calendar>

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
