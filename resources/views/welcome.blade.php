@extends('layouts.app')

@section('title', config('app.name') . ' - Mastodon log archives service')


@section('open_graph')
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row py-3 justify-content-md-center">
            <div class="col-md-8">
                <div class="jumbotron">
                    <h1>tootlog</h1>
                    <p>Mastodon log archives service.</p>
                    <p>
                        <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login</a>
                        <a class="btn btn-primary btn-lg" href="{{ route('register') }}" role="button">Register</a>
                    </p>
                    <small>
                        {{ config('tootlog.version') }}
                    </small>
                </div>

                <h2>Usage</h2>
                <div class="card mb-2">
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        Enter user name(only a-zA-Z0-9_-), e-mail, password. Does not send e-mail.
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header">
                        Add Mastodon Account
                    </div>
                    <div class="card-body">
                        Enter Mastodon instance's url. Authorize by OAuth.
                    </div>
                </div>

                <h2>Sample</h2>
                <div class="card">
                    <div class="card-body">
                        <a href="https://tootlog.net/@tootlog">https://tootlog.net/@tootlog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
