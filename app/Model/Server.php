<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'app_id',
        'domain',
        'client_id',
        'client_secret',
    ];
}
