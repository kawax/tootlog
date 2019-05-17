<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Presenter\StatusPresenter;

class Status extends Model
{
    use SoftDeletes;
    use StatusPresenter;

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
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'local_datetime',
        'name',
    ];

    /**
     * acct
     *
     * @return string
     */
    public function getAcctAttribute(): string
    {
        $domain = parse_url($this->account->url, PHP_URL_HOST);

        return $this->account->username.'@'.$domain;
    }

    /**
     * 表示用の名前
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = $this->account->name ?? '';

        return $name;
    }

    /**
     * @return \Carbon\Carbon|mixed|null
     */
    public function getLocalDatetimeAttribute()
    {
        $datetime = $this->created_at;

        return $datetime;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reblog()
    {
        return $this->belongsTo(Reblog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
