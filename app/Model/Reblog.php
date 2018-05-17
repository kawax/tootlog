<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reblog extends Model
{
    /**
     * @var array
     */
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

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
    ];

    /**
     * 表示用の名前
     *
     * @return string|null
     */
    public function getNameAttribute(): ?string
    {
        $name = $this->display_name ?? $this->username ?? '';

        return $name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
