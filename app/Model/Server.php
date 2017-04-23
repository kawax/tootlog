<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $guarded = ['id'];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
