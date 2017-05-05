<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'theme',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * モデルのルートキーの取得
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function statuses()
    {
        return $this->hasManyThrough(Status::class, Account::class);
    }

    public function tags()
    {
        $status_id = $this->statuses()
                          ->where('accounts.locked', false)
                          ->pluck('statuses.id');

        $tag_id = \DB::table('status_tag')
                     ->whereIn('status_id', $status_id)
                     ->pluck('tag_id')
                     ->unique()
                     ->toArray();

        return Tag::withCount('statuses')
                  ->orderBy('statuses_count', 'desc')
                  ->find($tag_id);
    }
}
