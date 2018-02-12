@extends('layouts.app')

@section('title', '@' . $user->name . '/archives' . ' - ' . config('app.name', 'tootlog'))

@section('description', '@' . $user->name . ' archives')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 order-md-last">
                <nav aria-label="breadcrumb">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">archives</li>
                </ol>
                </nav>

                <h2>Archives</h2>

                <div class="list-group">

                    @foreach($archives as $date => $archive)

                        <a href="{{ route('open.user.date.day', [
                        'user' => $user->name ,
                        'year' => explode('-', $date)[0],
                        'month' => explode('-', $date)[1]]) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            {{ $date }}

                            <span class="badge badge-pill badge-secondary ml-auto">{{ $archive->count() }}</span>

                        </a>

                    @endforeach
                </div>
            </div>

            @include('open.side')
        </div>
    </div>
@endsection
