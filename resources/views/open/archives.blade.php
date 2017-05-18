@extends('layouts.app')

@section('title', '@' . $user->name . '/archives' . ' - ' . config('app.name', 'tootlog'))

@section('description', '@' . $user->name . ' archives')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                <ol class="breadcrumb">
                    <li><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                    <li class="active">archives</li>
                </ol>

                <h2>Archives</h2>

                <div class="list-group">

                    @foreach($archives as $date => $archive)

                        <a href="{{ route('open.user.date.day', [
                        'user' => $user->name ,
                        'year' => explode('-', $date)[0],
                        'month' => explode('-', $date)[1]]) }}"
                           class="list-group-item">

                            <span class="badge">{{ $archive->count() }}</span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            {{ $date }}
                        </a>

                    @endforeach
                </div>
            </div>

            @include('open.side')
        </div>
    </div>
@endsection
