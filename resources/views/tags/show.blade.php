@extends('layouts.app')

@section('title', '#'.  $tag->name . ' ' . $user->name . '@' . config('app.name', 'tootlog'))

@if(!empty($statuses->first()->content))
    @section('description', strip_tags($statuses->first()->content))
@endif

@push('scripts')
    <meta name="robots" content="none">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-md-last">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tags.index', $user) }}">tags</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#{{ $tag->name  }}</li>
                    </ol>
                </nav>

                @include('home.search', [
                'search_route' => 'tags.show',
                'search_param' => [$user, $tag],
                'search_in' => '#' . $tag->name
                ])

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
