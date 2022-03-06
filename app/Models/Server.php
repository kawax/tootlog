<?php

namespace App\Models;

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
        'version',
        'streaming',
    ];

    /**
     * streaming api url.
     *
     * @param  string  $streaming
     * @return string
     */
    public function getStreamingAttribute($streaming): string
    {
        if (! is_null($streaming)) {
            return $streaming;
        }

        $domain = data_get(config('tootlog.streaming', []), $this->domain, $this->domain);

        return str_replace('http', 'ws', $domain);
    }

    /**
     * @return string
     */
    public function getFaviconAttribute(): string
    {
        return $this->domain.'/'.data_get(config('tootlog.favicon', []), $this->domain, 'favicon.ico');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
