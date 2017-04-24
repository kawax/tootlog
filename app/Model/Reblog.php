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

    /**
     * 表示用の名前
     *
     * @return mixed|string
     */
    public function getNameAttribute()
    {
        $name = empty($this->display_name) ? $this->username : $this->display_name;

        return $name;
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
