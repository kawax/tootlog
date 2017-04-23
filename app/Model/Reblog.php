<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reblog extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
