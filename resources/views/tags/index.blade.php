@extends('layouts.app')

@section('title', '@' .  $user->name . '/tags - ' . config('app.name', 'tootlog'))

@section('description', '@' .  $user->name . ' tags')

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
                        <li class="breadcrumb-item active" aria-current="page">tags</li>
                    </ol>
                </nav>

                <div class="list-group">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', ['user' => $user->name ,'tag' => $tag]) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            #{{ $tag->name }}
                            <span class="badge badge-pill badge-secondary ml-auto">{{ $tag->statuses_count }}</span>

                        </a>
                    @endforeach
                </div>

            </div>

            @include('open.side')
        </div>
    </div>
@endsection
