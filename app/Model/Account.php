<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use McCool\LaravelAutoPresenter\HasPresenter;
use App\Presenter\AccountPresenter;

class Account extends Model implements HasPresenter
{
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

    public function getPresenterClass()
    {
        return AccountPresenter::class;
    }

    /**
     * acct
     *
     * @return string
     */
    public function getAcctAttribute()
    {
        $domain = parse_url($this->url, PHP_URL_HOST);

        return $this->username . '@' . $domain;
    }


    /**
     * domain
     *
     * @return string
     */
    public function getDomainAttribute()
    {
        $domain = parse_url($this->url, PHP_URL_HOST);

        return $domain;
    }

    /**
     * @return mixed|string
     */
    public function getNameAttribute()
    {
        $name = empty($this->display_name) ? $this->username : $this->display_name;

        return $name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
