<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

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
        'reblog_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'local_datetime',
        'name',
    ];

    /**
     * acct.
     *
     * @return string
     */
    public function getAcctAttribute(): string
    {
        $domain = parse_url($this->account->url, PHP_URL_HOST);

        return $this->account->username.'@'.$domain;
    }

    /**
     * 表示用の名前.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->account->name ?? '';
    }

    /**
     * @return \Carbon\Carbon|mixed|null
     */
    public function getLocalDatetimeAttribute()
    {
        return $this->created_at;
    }

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return BelongsTo
     */
    public function reblog(): BelongsTo
    {
        return $this->belongsTo(Reblog::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
