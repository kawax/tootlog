# Copilot Onboarding Guide for tootlog

Welcome to the tootlog project! This guide will help GitHub Copilot understand the codebase and assist you effectively in contributing to this Mastodon log archives service.

## Project Overview

**tootlog** is a Laravel-based web application that serves as a Mastodon log archives service. It allows users to:

- Connect their Mastodon accounts via OAuth
- Automatically archive their posts/toots from various Mastodon instances
- Browse and search through their archived content
- Export their data in CSV format
- Share public archives with custom URLs

### Key Features
- Multi-instance Mastodon support
- OAuth authentication with Mastodon servers
- Background job processing for post archiving
- Public timeline sharing (@username URLs)
- Date-based browsing and filtering
- CSV export functionality
- Real-time status updates via Laravel Horizon

## セキュリティ
- APIで取得した **htmlを含むユーザー生成コンテンツ** を扱うのでXSS対策などセキュリティを徹底する。
- マストドン側で **安全にサニタイズされたhtml** を返してる場合はそのまま表示可能。Bladeなら`{!! $variable !!}`で表示。Vueなら`v-html`で表示。
- **ログインしている現在のユーザーだけが表示できるページ** と **誰でも表示できる公開ページ** が混在しているのでLaravelのAuthorization機能でしっかり制御する。他のユーザーによるupdateやdelete操作を防止する。

## Technology Stack

### Starter Kit
- Livewire Starter Kit
  -  Migrated from old bootstrap-based frontend.

### Backend
- **Framework**: Laravel 12+ (PHP 8.4+)
- **Database**: MySQL (SQLite in local development)
- **Queue**: Redis with Laravel Horizon
- **Authentication**: Laravel Fortify (with 2FA support)
- **API Integration**: revolution/laravel-mastodon-api
- **OAuth**: revolution/socialite-mastodon

### Frontend
- Flux UI Free
- Tailwind 4
- Livewire and Volt
- Vite
- Vue 3

### Development Tools
- **Code Style**: Laravel Pint
- **Testing**: PHPUnit 11+
- **CI/CD**: GitHub Actions
- **Deployment**: Laravel Forge
- **Monitoring**: Laravel Horizon for queues

## Setup Instructions

### Local Development Setup

1. **Clone and Install Dependencies**
   ```bash
   git clone <repository-url>
   cd tootlog
   composer setup
   ```

2. **Configure Environment Variables**
   Edit `.env` file with your settings:
   ```env
   MASTODON_REDIRECT=http://127.0.0.1:8000/accounts/callback
   ```

3. **Database Setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

データベースを全て削除してseedまで実行。

4. **Start Development Server**
   ```bash
   composer run dev
   ```

Playwrightで表示するローカルURL:
http://127.0.0.1:8000/
テストユーザーはemail=test@example.com、password=passwordでログイン可能。

## Codebase Structure

### Directory Organization
```
app/
├── Actions/           # Single-purpose action classes
├── Console/
│   └── Commands/      # Artisan commands
│       ├── Status/    # Status-related commands
│       ├── TootInfoCommand.php
│       └── InstanceVersionCommand.php
├── Http/
│   └── Controllers/
│       ├── Home/      # Authenticated user controllers
│       └── Open/      # Public access controllers
├── Jobs/              # Background job classes
├── Livewire/          # Livewire components
├── Models/            # Eloquent models
│   └── Concerns/      # Model traits
├── Policies/          # Authorization policies
└── Providers/         # Service providers

config/
├── app.php           # Main Laravel config
├── tootlog.php       # Application-specific config
└── ...

database/
├── migrations/       # Database schema changes
├── factories/        # Model factories for testing
└── seeders/          # Database seeders

resources/
├── views/
│   ├── layouts/      # Blade layout templates
│   ├── pages/        # Static pages
│   └── livewire/     # Livewire components
└── js/               # Frontend JavaScript

routes/
├── web.php           # Main web routes (authenticated)
├── open.php          # Public routes
└── console.php       # Artisan commands

tests/
├── Feature/          # Integration tests
└── Unit/             # Unit tests
```

### Key Models and Relationships

#### Core Models
- **User**: Application users
  - `hasMany(Account)` - Mastodon accounts
  - Uses traits: `WithUserAccount`, `WithUserArchives`, `WithUserStatus`, `WithUserTag`

- **Account**: Connected Mastodon accounts
  - `belongsTo(User)` - Owner
  - `belongsTo(Server)` - Mastodon instance
  - `hasMany(Status)` - Archived posts
  - Uses traits: `WithAccountStatus`, `Mastodon`

- **Server**: Mastodon instances
  - `hasMany(Account)` - Connected accounts
  - Stores instance metadata (version, streaming URL)

- **Status**: Individual posts/toots
  - `belongsTo(Account)` - Author account
  - `hasMany(Reblog)` - Reblogs/boosts
  - Supports soft deletes

### Route Structure

#### Authenticated Routes (`/routes/home.php`)
- `POST /accounts` - Add Mastodon account
- `GET /accounts/callback` - OAuth callback
- `DELETE /accounts/delete/{account}` - Remove account
- `GET /home/timeline/{username}@{domain}` - Account-specific timeline
- `GET /home` - Dashboard

#### Public Routes (`/routes/open.php`)
- `GET /@{user}` - User's public archive
- `GET /@{user}/{username}@{domain}` - Public account timeline
- `GET /@{user}/{username}@{domain}/{status_id}` - Individual post
- `GET /@{user}/date/{year}/{month}/{day}` - Posts by date
- `GET /@{user}/archives` - Archive overview

## Language
- viewなどでは全て英語を使う。実際のユーザーは日本人が多いのでシンプルで短い説明にする。
