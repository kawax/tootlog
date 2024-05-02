<?php

namespace App\Models;

use App\Models\Concerns\WithAccountStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Revolution\Mastodon\Traits\Mastodon;

class Account extends Model
{
    use HasFactory;
    use Mastodon;
    use WithAccountStatus;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'server_id',
        'account_id',
        'since_id',
        'fails',
        'token',
        'username',
        'acct',
        'display_name',
        'locked',
        'account_created_at',
        'statuses_count',
        'following_count',
        'followers_count',
        'note',
        'url',
        'avatar',
        'avatar_static',
        'header',
        'header_static',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function scopeByAcct(Builder $query, string $username, string $domain): void
    {
        $url = '://'.$domain.'/@'.$username;

        $query->where('url', 'like', '%'.$url);
    }

    public function acct(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->username.'@'.parse_url($this->url, PHP_URL_HOST),
        );
    }

    public function domain(): Attribute
    {
        return Attribute::make(
            get: fn () => parse_url($this->url, PHP_URL_HOST),
        );
    }

    public function favicon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->server->domain.'/'.data_get(config('tootlog.favicon', []), $this->server->domain, 'favicon.ico'),
        );
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => filled($this->display_name) ? $this->display_name : $this->username,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    protected function mastodonDomain(): string
    {
        return $this->server->domain;
    }

    protected function mastodonToken(): string
    {
        return $this->token;
    }
}
