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

    @vite(['resources/js/welcome.ts'])

    <style>
        :root {
            --welcome-bg: #0a0a0f;
            --welcome-primary: #6366f1;
            --welcome-secondary: #a855f7;
            --welcome-accent: #22d3ee;
            --welcome-text: #e2e8f0;
            --welcome-text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--welcome-bg);
            color: var(--welcome-text);
            font-family: 'Space Mono', monospace;
            overflow: hidden;
            min-height: 100vh;
        }

        #welcome-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .welcome-overlay {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            pointer-events: none;
        }

        .welcome-content {
            text-align: center;
            pointer-events: auto;
            max-width: 600px;
        }

        .welcome-logo {
            font-family: 'Syne', sans-serif;
            font-size: clamp(3rem, 12vw, 7rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, var(--welcome-primary) 0%, var(--welcome-secondary) 50%, var(--welcome-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            animation: logo-glow 3s ease-in-out infinite alternate;
            text-shadow: 0 0 80px rgba(99, 102, 241, 0.3);
        }

        @keyframes logo-glow {
            0% { filter: drop-shadow(0 0 20px rgba(99, 102, 241, 0.4)); }
            100% { filter: drop-shadow(0 0 40px rgba(168, 85, 247, 0.6)); }
        }

        .welcome-tagline {
            font-size: 0.875rem;
            color: var(--welcome-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.3em;
            margin-bottom: 3rem;
        }

        .welcome-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .welcome-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: 2px solid transparent;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .welcome-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .welcome-btn:hover::before {
            left: 100%;
        }

        .welcome-btn-primary {
            background: linear-gradient(135deg, var(--welcome-primary), var(--welcome-secondary));
            color: #fff;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
        }

        .welcome-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.6);
        }

        .welcome-btn-secondary {
            background: transparent;
            color: var(--welcome-text);
            border-color: var(--welcome-text-muted);
        }

        .welcome-btn-secondary:hover {
            border-color: var(--welcome-accent);
            color: var(--welcome-accent);
            transform: translateY(-2px);
        }

        .welcome-sample {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(100, 116, 139, 0.2);
        }

        .welcome-sample-label {
            font-size: 0.75rem;
            color: var(--welcome-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: 0.5rem;
        }

        .welcome-sample-link {
            color: var(--welcome-accent);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .welcome-sample-link:hover {
            color: var(--welcome-secondary);
        }

        .welcome-version {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            font-size: 0.75rem;
            color: var(--welcome-text-muted);
            z-index: 20;
            pointer-events: auto;
        }

        .welcome-loading {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            font-size: 0.75rem;
            color: var(--welcome-text-muted);
            z-index: 20;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .welcome-loading-dot {
            width: 6px;
            height: 6px;
            background: var(--welcome-accent);
            border-radius: 50%;
            animation: loading-pulse 1.4s ease-in-out infinite;
        }

        .welcome-loading-dot:nth-child(2) { animation-delay: 0.2s; }
        .welcome-loading-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes loading-pulse {
            0%, 80%, 100% { opacity: 0.3; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 640px) {
            .welcome-actions {
                flex-direction: column;
                width: 100%;
            }

            .welcome-btn {
                width: 100%;
            }
        }
    </style>
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
