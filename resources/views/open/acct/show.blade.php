@extends('layouts.app')

@section('title', $acct->acct . '/' . $status->status_id . ' - ' . config('app.name', 'tootlog'))

@section('description', strip_tags($status->content))

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
                        <li class="breadcrumb-item"><a
                                    href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('open.account.index', [$user, $acct->username, $acct->domain]) }}">{{ $acct->acct  }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $status->status_id }}</li>
                    </ol>
                </nav>

                @include('open.acct.profile')

                @include('status.item')
            </div>

            @include('open.side')

        </div>
    </div>
@endsection
