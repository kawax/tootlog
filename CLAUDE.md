# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Tootlog is a Laravel application that archives and displays Mastodon statuses. It allows users to authenticate with Mastodon instances, import their toots, and browse them in various ways.

## Development Commands

### Build and Assets
- `npm run dev` - Start Vite development server for frontend assets
- `npm run build` - Build production assets with Vite

### Code Quality
- `php artisan pint` - Run Laravel Pint for PHP code formatting
- `composer ide-helper:generate` - Generate IDE helper files (run after updating dependencies)
- `composer ide-helper:models` - Generate model helpers for better IDE support

### Testing
- `php artisan test` - Run all tests (Unit and Feature tests)
- `php artisan test --testsuite=Unit` - Run only unit tests
- `php artisan test --testsuite=Feature` - Run only feature tests
- `php artisan test --filter TestClassName` - Run specific test class

### Development Server
- `php artisan serve` - Start local development server
- `composer sail:up` - Start Laravel Sail development environment
- `composer sail:down` - Stop Laravel Sail environment

### Database and Queue
- `php artisan migrate` - Run database migrations
- `php artisan horizon` - Start Horizon queue worker for processing jobs

## Architecture Overview

### Core Models
- **User** - Main authentication model with email verification
- **Account** - Represents a Mastodon account linked to a user
- **Status** - Individual toots/posts from Mastodon
- **Tag** - Hashtags associated with statuses
- **Server** - Mastodon instance information
- **Reblog** - Reblogged status references

### Key Relationships
- Users can have multiple Mastodon accounts
- Accounts have many statuses (toots)
- Statuses can have tags and can be reblogs of other statuses
- Servers track Mastodon instance versions and capabilities

### Authentication
- Uses Laravel Fortify for authentication features
- Supports OAuth authentication with Mastodon instances via Socialite
- Email verification is required for users

### Job Processing
- **GetStatusJob** - Fetches statuses from Mastodon API
- **InstanceVersionJob** - Updates Mastodon instance information
- **ExportCsvJob** - Generates CSV exports of user statuses

### Frontend Stack
- Vue 3 for reactive components
- Bootstrap 5 for UI framework
- Vite for asset bundling
- Livewire for server-side reactive components

### Key Features
- Timeline views with infinite scroll
- Archive browsing by date
- Tag-based filtering
- Public profile pages
- CSV export functionality
- Real-time status updates via Livewire

## Important Directories
- `app/Http/Controllers/Home/` - Authenticated user controllers
- `app/Http/Controllers/Open/` - Public-facing controllers
- `app/Jobs/` - Background job processors
- `app/Livewire/` - Livewire components
- `app/Models/Concerns/` - Model traits for shared functionality
- `resources/js/components/` - Vue components
- `resources/views/` - Blade templates

## Configuration
- Mastodon OAuth credentials in `.env`
- Queue configuration uses Horizon for production
- Mail configuration supports Mailgun
- Storage for CSV exports in `storage/app/csv/`
