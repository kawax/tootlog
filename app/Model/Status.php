<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Presenter\StatusPresenter;

class Status extends Model
{
    use SoftDeletes;
    use StatusPresenter;

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

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'local_datetime',
        'name',
    ];

    /**
     * acct
     *
     * @return string
     */
    public function getAcctAttribute()
    {
        $domain = parse_url($this->account->url, PHP_URL_HOST);

        return $this->account->username . '@' . $domain;
    }

    /**
     * 表示用の名前
     *
     * @return mixed|string
     */
    public function getNameAttribute()
    {
        $name = $this->account->name;

        return $name;
    }

    public function getLocalDatetimeAttribute()
    {
        //TODO:ローカル時間での表示対応
        $datetime = $this->created_at;//->setTimezone('Asia/Tokyo')->toDateTimeString();

        return $datetime;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function reblog()
    {
        return $this->belongsTo(Reblog::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
