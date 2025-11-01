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

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.14
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v12
- laravel/horizon (HORIZON) - v5
- laravel/prompts (PROMPTS) - v0
- laravel/socialite (SOCIALITE) - v5
- livewire/livewire (LIVEWIRE) - v3
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- phpunit/phpunit (PHPUNIT) - v11
- vue (VUE) - v3

## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.


=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double check the available parameters.

## URLs
- Whenever you share a project URL with the user you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain / IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation specific for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The 'search-docs' tool is perfect for all Laravel related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel-ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries - package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit"
3. Quoted Phrases (Exact Position) - query="infinite scroll" - Words must be adjacent and in that order
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit"
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms


=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over comments. Never use comments within the code itself unless there is something _very_ complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.


=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] <name>` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.


=== laravel/v12 rules ===

## Laravel 12

- Use the `search-docs` tool to get version specific documentation.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

### Laravel 12 Structure
- No middleware files in `app/Http/Middleware/`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- **No app\Console\Kernel.php** - use `bootstrap/app.php` or `routes/console.php` for console configuration.
- **Commands auto-register** - files in `app/Console/Commands/` are automatically available and do not require manual registration.

### Database
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 11 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models
- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.


=== livewire/core rules ===

## Livewire Core
- Use the `search-docs` tool to find exact version specific documentation for how to write Livewire & Livewire tests.
- Use the `php artisan make:livewire [Posts\CreatePost]` artisan command to create new components
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend, they're like regular HTTP requests. Always validate form data, and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()` for initialization and reactive side effects:

<code-snippet name="Lifecycle hook examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>


## Testing Livewire

<code-snippet name="Example Livewire component test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>


    <code-snippet name="Testing a Livewire component exists within a page" lang="php">
        $this->get('/posts/create')
        ->assertSeeLivewire(CreatePost::class);
    </code-snippet>


=== livewire/v3 rules ===

## Livewire 3

### Key Changes From Livewire 2
- These things changed in Livewire 2, but may not have been updated in this application. Verify this application's setup to ensure you conform with application conventions.
    - Use `wire:model.live` for real-time updates, `wire:model` is now deferred by default.
    - Components now use the `App\Livewire` namespace (not `App\Http\Livewire`).
    - Use `$this->dispatch()` to dispatch events (not `emit` or `dispatchBrowserEvent`).
    - Use the `components.layouts.app` view as the typical layout path (not `layouts.app`).

### New Directives
- `wire:show`, `wire:transition`, `wire:cloak`, `wire:offline`, `wire:target` are available for use. Use the documentation to find usage examples.

### Alpine
- Alpine is now included with Livewire, don't manually include Alpine.js.
- Plugins included with Alpine: persist, intersect, collapse, and focus.

### Lifecycle Hooks
- You can listen for `livewire:init` to hook into Livewire initialization, and `fail.status === 419` for the page expiring:

<code-snippet name="livewire:load example" lang="js">
document.addEventListener('livewire:init', function () {
    Livewire.hook('request', ({ fail }) => {
        if (fail && fail.status === 419) {
            alert('Your session expired');
        }
    });

    Livewire.hook('message.failed', (message, component) => {
        console.error(message);
    });
});
</code-snippet>


=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.


=== phpunit/core rules ===

## PHPUnit Core

- This application uses PHPUnit for testing. All tests must be written as PHPUnit classes. Use `php artisan make:test --phpunit <name>` to create a new test.
- If you see a test using "Pest", convert it to PHPUnit.
- Every time a test has been updated, run that singular test.
- When the tests relating to your feature are passing, ask the user if they would like to also run the entire test suite to make sure everything is still passing.
- Tests should test all of the happy paths, failure paths, and weird paths.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files, these are core to the application.

### Running Tests
- Run the minimal number of tests, using an appropriate filter, before finalizing.
- To run all tests: `php artisan test`.
- To run all tests in a file: `php artisan test tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --filter=testName` (recommended after making a change to a related file).


=== tests rules ===

## Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test` with a specific filename or filter.


=== laravel/fortify rules ===

## Laravel Fortify

Fortify is a headless authentication backend that provides authentication routes and controllers for Laravel applications.

**Before implementing any authentication features, use the `search-docs` tool to get the latest docs for that specific feature.**

### Configuration & Setup
- Check `config/fortify.php` to see what's enabled. Use `search-docs` for detailed information on specific features.
- Enable features by adding them to the `'features' => []` array: `Features::registration()`, `Features::resetPasswords()`, etc.
- To see the all Fortify registered routes, use the `list-routes` tool with the `only_vendor: true` and `action: "Fortify"` parameters.
- Fortify includes view routes by default (login, register). Set `'views' => false` in the configuration file to disable them if you're handling views yourself.

### Customization
- Views can be customized in `FortifyServiceProvider`'s `boot()` method using `Fortify::loginView()`, `Fortify::registerView()`, etc.
- Customize authentication logic with `Fortify::authenticateUsing()` for custom user retrieval / validation.
- Actions in `app/Actions/Fortify/` handle business logic (user creation, password reset, etc.). They're fully customizable, so you can modify them to change feature behavior.

## Available Features
- `Features::registration()` for user registration.
- `Features::emailVerification()` to verify new user emails.
- `Features::twoFactorAuthentication()` for 2FA with QR codes and recovery codes.
  - Add options: `['confirmPassword' => true, 'confirm' => true]` to require password confirmation and OTP confirmation before enabling 2FA.
- `Features::updateProfileInformation()` to let users update their profile.
- `Features::updatePasswords()` to let users change their passwords.
- `Features::resetPasswords()` for password reset via email.
</laravel-boost-guidelines>
