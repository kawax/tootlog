<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Presenter\UserPresenter;

class User extends Authenticatable
{
    use Notifiable;
    use UserPresenter;

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
        'special_key',
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
}
