@extends('layouts.app')

@section('title', '@' .  $user->name . '/tags - ' . config('app.name', 'tootlog'))

@section('description', '@' .  $user->name . ' tags')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-push-4">
                <ol class="breadcrumb">
                    <li><a href="{{ route('open.user', $user) }}">{{ '@' . $user->name  }}</a></li>
                    <li class="active">tags</li>
                </ol>

                <div class="list-group">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', ['user' => $user->name ,'tag' => $tag]) }}"
                           class="list-group-item">
                            <span class="badge">{{ $tag->statuses_count }}</span>
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>

            </div>

            @include('open.side')
        </div>
    </div>
@endsection
