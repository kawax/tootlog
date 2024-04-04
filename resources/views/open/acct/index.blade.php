@extends('layouts.app')

@section('title', $acct->acct . ' - ' . config('app.name', 'tootlog'))

@section('description', strip_tags($acct->note))

@push('robots')
    <meta name="robots" content="nofollow">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-md-last">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('open.user', $user) }}" class="text-decoration-none">{{ '@' . $user->name  }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $acct->acct  }}</li>
                    </ol>
                </nav>

                @include('open.acct.profile')

                @include('home.search', [
                'search_route' => 'open.account.index',
                'search_param' => [$user, $acct->username, $acct->domain],
                'search_in' => $acct->acct
                ])

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
