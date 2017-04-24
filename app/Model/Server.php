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

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
