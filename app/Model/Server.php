<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
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
     * @return mixed
     */
    public function getStreamingAttribute()
    {
        $domain = array_get(config('tootlog.streaming'), $this->domain, $this->domain);
        $domain = str_replace('http', 'ws', $domain);

        return $domain;
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
