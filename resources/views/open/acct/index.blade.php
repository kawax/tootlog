@extends('layouts.app')

@section('title', $acct->acct . ' - ' . config('app.name', 'tootlog'))

@section('description', strip_tags($acct->note))

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
                        <li class="breadcrumb-item active" aria-current="page">{{ $acct->acct  }}</li>
                    </ol>
                </nav>

                @include('open.acct.profile')

                @include('home.search', [
                'search_route' => 'open.account.index',
                'search_param' => [$user, $acct->username, $acct->domain],
                'search_in' => $acct->acct
                ])

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
