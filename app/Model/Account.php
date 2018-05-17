<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Presenter\AccountPresenter;

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
     * acct
     *
     * @return string
     */
    public function getAcctAttribute(): string
    {
        $domain = parse_url($this->url, PHP_URL_HOST);

        return $this->username . '@' . $domain;
    }

    /**
     * domain
     *
     * @return string
     */
    public function getDomainAttribute(): string
    {
        $domain = parse_url($this->url, PHP_URL_HOST);

        return $domain;
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = empty($this->display_name) ? $this->username : $this->display_name;

        return $name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * @return string
     */
    protected function mastodonDomain()
    {
        return $this->server->domain;
    }

    /**
     * @return string
     */
    protected function mastodonToken()
    {
        return $this->token;
    }
}
