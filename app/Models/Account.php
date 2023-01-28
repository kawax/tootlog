<?php

namespace App\Models;

use App\Models\Presenter\AccountPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Revolution\Mastodon\Traits\Mastodon;

class Account extends Model
{
    use AccountPresenter;
    use Mastodon;

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

    /**
     * acct.
     *
     * @return string
     */
    public function getAcctAttribute(): string
    {
        $domain = parse_url($this->url, PHP_URL_HOST);

        return $this->username.'@'.$domain;
    }

    /**
     * domain.
     *
     * @return string
     */
    public function getDomainAttribute(): string
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return filled($this->display_name) ? $this->display_name : $this->username;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    /**
     * @return string
     */
    protected function mastodonDomain(): string
    {
        return $this->server->domain;
    }

    /**
     * @return string
     */
    protected function mastodonToken(): string
    {
        return $this->token;
    }
}
