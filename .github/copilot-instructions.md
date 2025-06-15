# Copilot Onboarding Guide for tootlog

Welcome to the tootlog project! This guide will help GitHub Copilot understand the codebase and assist you effectively in contributing to this Mastodon log archives service.

## Project Overview

**tootlog** is a Laravel-based web application that serves as a Mastodon log archives service. It allows users to:

- Connect their Mastodon accounts via OAuth
- Automatically archive their posts/toots from various Mastodon instances
- Browse and search through their archived content
- Export their data in CSV format
- Share public archives with custom URLs
- Filter content by tags, dates, and accounts

**Live Site**: https://tootlog.net/
**License**: MIT
**Current Version**: v1.18.0 (see `config/tootlog.php`)

### Key Features
- Multi-instance Mastodon support
- OAuth authentication with Mastodon servers
- Background job processing for post archiving
- Public timeline sharing (@username URLs)
- Tag-based content organization
- Date-based browsing and filtering
- CSV export functionality
- Real-time status updates via Laravel Horizon

## Technology Stack

### Backend
- **Framework**: Laravel 12+ (PHP 8.2+)
- **Database**: MySQL
- **Queue**: Redis with Laravel Horizon
- **Authentication**: Laravel Fortify (with 2FA support)
- **API Integration**: revolution/laravel-mastodon-api
- **OAuth**: revolution/socialite-mastodon

### Frontend
- **CSS Framework**: Bootstrap 5.2+
- **JavaScript**: Vue 3 with Vite
- **Interactive Components**: Livewire 3
- **Icons**: Font Awesome 6
- **Emoji**: Twemoji API

### Development Tools
- **Code Style**: Laravel Pint
- **Testing**: PHPUnit 11+
- **Local Development**: Laravel Sail
- **CI/CD**: GitHub Actions
- **Deployment**: Laravel Forge
- **Monitoring**: Laravel Horizon for queues

## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL database
- Redis server

### Local Development Setup

1. **Clone and Install Dependencies**
   ```bash
   git clone <repository-url>
   cd tootlog
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure Environment Variables**
   Edit `.env` file with your settings:
   ```env
   APP_NAME=tootlog
   APP_URL=http://localhost:8000
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tootlog
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   REDIS_HOST=127.0.0.1
   REDIS_PORT=6379
   
   # Mastodon OAuth (required for functionality)
   MASTODON_DOMAIN=your-instance.social
   MASTODON_ID=your_client_id
   MASTODON_SECRET=your_client_secret
   MASTODON_REDIRECT=http://localhost:8000/accounts/callback
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build Frontend Assets**
   ```bash
   npm run build
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   php artisan horizon  # In separate terminal for queue processing
   ```

### Using Laravel Sail (Docker)
```bash
composer run sail:up
sail artisan migrate
sail artisan db:seed
sail npm run build
```

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
  - `belongsToMany(Tag)` - Associated hashtags
  - `hasMany(Reblog)` - Reblogs/boosts
  - Supports soft deletes

- **Tag**: Hashtags from posts
  - `belongsToMany(Status)` - Tagged posts

### Route Structure

#### Authenticated Routes (`/routes/web.php`)
- `POST /accounts` - Add Mastodon account
- `GET /accounts/callback` - OAuth callback
- `DELETE /accounts/delete/{account}` - Remove account
- `GET /timeline` - Personal timeline
- `GET /timeline/{username}@{domain}` - Account-specific timeline
- `GET|POST /preferences` - User preferences
- `POST /export/csv` - CSV export
- `GET /home` - Dashboard

#### Public Routes (`/routes/open.php`)
- `GET /@{user}` - User's public archive
- `GET /@{user}/{username}@{domain}` - Public account timeline
- `GET /@{user}/{username}@{domain}/{status_id}` - Individual post
- `GET /@{user}/date/{date}` - Posts by date
- `GET /@{user}/tags` - Tag index
- `GET /@{user}/tags/{tag}` - Posts by tag
- `GET /@{user}/archives` - Archive overview

### Background Jobs

#### Key Job Classes
- **GetStatusJob**: Fetches new posts from Mastodon API
- **ExportCsvJob**: Generates CSV exports
- **InstanceVersionJob**: Updates Mastodon instance information

#### Job Processing
- Uses Redis as queue driver
- Laravel Horizon for monitoring and management
- Processes jobs in batches to respect API rate limits
- Automatic retry logic for failed API calls

### Configuration Files

#### `config/tootlog.php`
Application-specific settings:
- `version` - Current app version
- `account_limit` - Max accounts to update simultaneously
- `account_fails` - Failure threshold for dead servers
- `streaming` - Custom streaming URLs
- `favicon` - Custom favicons for instances
- `special_key` - Premium feature key

## Main Workflows

### User Registration and Account Setup
1. User registers via Laravel Fortify
2. User adds Mastodon account via OAuth
3. System validates and stores account credentials
4. `GetStatusJob` queued to fetch initial posts
5. Background processing begins archiving content

### Content Archiving Process
1. Scheduled command triggers status updates
2. `GetStatusJob` fetches posts via Mastodon API
3. Posts processed and stored in database
4. Tags extracted and associated
5. Reblogs/boosts handled separately
6. Public timelines updated

### Public Timeline Access
1. User visits `@{username}` URL
2. System loads user's public settings
3. Timeline filtered by privacy preferences
4. Content rendered with pagination
5. SEO metadata and sitemaps generated

## Development Best Practices

### Code Style and Standards
- **PSR-12 Compliance**: Use Laravel Pint for formatting
  ```bash
  vendor/bin/pint        # Fix issues
  vendor/bin/pint --test # Check without fixing
  ```

- **Laravel Conventions**: Follow Laravel naming conventions
  - Controllers: PascalCase with "Controller" suffix
  - Models: Singular PascalCase
  - Migrations: snake_case with descriptive names
  - Routes: kebab-case for URIs

### Database Practices
- **Migrations**: Always use migrations for schema changes
- **Indexes**: Add appropriate indexes for query performance
- **Foreign Keys**: Use proper relationships and constraints
- **Soft Deletes**: Used for Status model to preserve data integrity

### API Integration
- **Rate Limiting**: Respect Mastodon API rate limits
- **Error Handling**: Implement retry logic for API failures
- **Token Management**: Secure storage of OAuth tokens
- **Instance Compatibility**: Handle different Mastodon versions

### Security Considerations
- **OAuth Tokens**: Stored encrypted in database
- **CSRF Protection**: Enabled for all forms
- **Input Validation**: Use Laravel's validation features
- **XSS Prevention**: Blade templates auto-escape output
- **SQL Injection**: Use Eloquent ORM exclusively

### Testing Guidelines
- **Feature Tests**: Test complete user workflows
- **Unit Tests**: Test individual model methods
- **Database Testing**: Use RefreshDatabase trait
- **Mocking**: Mock external API calls in tests
- **Coverage**: Maintain comprehensive test coverage

### Performance Optimization
- **Eager Loading**: Use `with()` to prevent N+1 queries
- **Caching**: Cache frequently accessed data
- **Queue Processing**: Use background jobs for heavy operations
- **Database Indexing**: Index commonly queried columns

## Common Pitfalls and FAQs

### API Integration Issues

**Q: Mastodon API calls are failing**
- Check instance compatibility and API version
- Verify OAuth token validity
- Review rate limiting and implement backoff
- Check network connectivity and SSL certificates

**Q: Posts are not being archived**
- Verify `GetStatusJob` is running via Horizon
- Check account `fails` counter in database
- Ensure Redis is running for queue processing
- Review Mastodon API token permissions

### Database Performance

**Q: Timeline queries are slow**
- Add indexes on commonly filtered columns
- Use eager loading for relationships
- Consider query optimization or caching
- Review database connection pooling

**Q: Storage space growing rapidly**
- Implement data retention policies
- Consider archiving old posts to cold storage
- Optimize media storage strategy
- Monitor disk space usage

### Frontend Issues

**Q: Assets not loading in production**
- Run `npm run build` to compile assets
- Check Vite configuration
- Verify asset URLs in templates
- Clear browser cache

**Q: Livewire components not working**
- Check JavaScript console for errors
- Verify Livewire is properly configured
- Ensure CSRF token is present
- Check network connectivity

### Authentication Problems

**Q: OAuth callback fails**
- Verify redirect URI matches exactly
- Check Mastodon app configuration
- Ensure SSL is properly configured
- Review session configuration

**Q: 2FA not working**
- Check Laravel Fortify configuration
- Verify QR code generation
- Test time synchronization
- Review recovery codes

### Queue Processing

**Q: Jobs are not processing**
- Ensure Redis is running
- Start Laravel Horizon
- Check queue configuration in `.env`
- Review failed jobs table

**Q: Memory issues with large jobs**
- Implement job chunking
- Increase PHP memory limit
- Optimize database queries
- Use job batching

### Development Environment

**Q: Sail containers won't start**
- Check Docker installation
- Verify port availability
- Review docker-compose.yml
- Check system resources

**Q: Tests are failing**
- Run `php artisan key:generate`
- Ensure test database is configured
- Check PHPUnit configuration
- Verify all dependencies are installed

## Debugging and Troubleshooting

### Log Locations
- **Application Logs**: `storage/logs/laravel.log`
- **Queue Logs**: Available in Horizon dashboard
- **Web Server Logs**: Check your web server configuration

### Useful Artisan Commands
```bash
# Application maintenance
php artisan queue:work        # Process queue jobs
php artisan horizon          # Start Horizon
php artisan cache:clear      # Clear application cache
php artisan config:clear     # Clear config cache
php artisan route:clear      # Clear route cache

# Custom commands
php artisan toot:info        # Post statistics to Mastodon
php artisan toot:version     # Update instance versions
php artisan toot:status      # Process status updates
```

### Performance Monitoring
- Use Laravel Telescope for request debugging
- Monitor Horizon for queue performance
- Check database slow query log
- Use Laravel Debugbar in development

## Contributing Guidelines

### Before You Start
1. Check existing issues and pull requests
2. Discuss major changes in issues first
3. Ensure you have proper development environment
4. Read this onboarding guide thoroughly

### Development Process
1. **Fork and Branch**: Create feature branch from `main`
2. **Code Standards**: Follow PSR-12 and Laravel conventions
3. **Testing**: Write tests for new functionality
4. **Documentation**: Update relevant documentation
5. **Code Review**: Submit PR for review

### Pull Request Checklist
- [ ] Tests pass (`vendor/bin/phpunit`)
- [ ] Code style check passes (`vendor/bin/pint --test`)
- [ ] No new security vulnerabilities
- [ ] Documentation updated if needed
- [ ] Migration scripts included if schema changes
- [ ] Changelog updated for user-facing changes

This guide should help you understand the tootlog codebase and contribute effectively. For additional questions, check the existing issues or create a new one for discussion.