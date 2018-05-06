<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'app_id',
        'domain',
        'redirect_uri',
        'client_id',
        'client_secret',
    ];

    /**
     * streaming api url
     *
     * @return string
     */
    public function getStreamingAttribute(): string
    {
        $domain = array_get(config('tootlog.streaming'), $this->domain, $this->domain);
        $domain = str_replace('http', 'ws', $domain);

        return $domain;
    }

    /**
     * @return string
     */
    public function getFaviconAttribute(): string
    {
        return $this->domain . '/' . array_get(config('tootlog.favicon'), $this->domain, 'favicon.ico');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
