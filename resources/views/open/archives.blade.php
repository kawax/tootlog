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

                @foreach($archives as $date => $archive)
                    @if(empty($month) or $month != substr($date, 0, 7))
                        @if(!$loop->first)</div>@endif
            <h3>{{ substr($date, 0, 7) }}</h3>
            <div class="list-group">
                @endif

                @php
                    $month = substr($date, 0, 7);
                @endphp

                <a href="{{ route('open.user.date', ['user' => $user->name ,'date' => $date]) }}"
                   class="list-group-item">
                    <span class="badge">{{ $archive->count() }}</span>
                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                    {{ $date }}
                </a>

                @if($loop->last)</div>@endif

            @endforeach

        </div>

        @include('open.side')
    </div>
    </div>
@endsection
