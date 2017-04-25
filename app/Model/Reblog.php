<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reblog extends Model
{
    protected $fillable = [
        'account_id',
        'status_id',
        'content',
        'spoiler_text',
        'created_at',
        'uri',
        'url',
        'acct',
        'display_name',
        'account_url',
        'avatar',
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
