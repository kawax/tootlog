<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Mastodon log archives service</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/welcome.css', 'resources/js/welcome.ts'])
</head>
<body>
    <canvas id="welcome-canvas"></canvas>

    <div class="welcome-overlay">
        <div class="welcome-content">
            <h1 class="welcome-logo">tootlog</h1>
            <p class="welcome-tagline">Mastodon log archives service</p>

            <div class="welcome-actions">
                <a href="{{ route('login') }}" class="welcome-btn welcome-btn-primary">Login</a>
                <a href="{{ route('register') }}" class="welcome-btn welcome-btn-secondary">Register</a>
            </div>

            <div class="welcome-sample">
                <p class="welcome-sample-label">Sample Archive</p>
                <a href="https://tootlog.net/@tootlog" class="welcome-sample-link">tootlog.net/@tootlog</a>
            </div>
        </div>
    </div>

    <div class="welcome-loading" id="welcome-loading">
        <div class="welcome-loading-dot"></div>
        <div class="welcome-loading-dot"></div>
        <div class="welcome-loading-dot"></div>
        <span>Loading toots...</span>
    </div>

    <div class="welcome-version">{{ config('tootlog.version') }}</div>
</body>
</html>
