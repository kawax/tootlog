<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

    protected $appends = [
        'local_datetime',
        'url',
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
        $name = empty($this->account->display_name) ? $this->account->username : $this->account->display_name;

        return $name;
    }

    public function getLocalDatetimeAttribute()
    {
        //TODO:ローカル時間での表示対応
        $datetime = $this->created_at;//->setTimezone('Asia/Tokyo')->toDateTimeString();

        return $datetime;
    }

    public function getUrlAttribute()
    {
        $url = $this->account->url . '/' . $this->status_id;

        return $url;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function reblog()
    {
        return $this->belongsTo(Reblog::class);
    }
}
