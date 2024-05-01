<?php

namespace App\Models;

use App\Models\Presenter\UserPresenter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    /**
     * ユーザーのアカウント.
     */
    public function allAccounts(): Collection
    {
        return $this->accounts()
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }

    /**
     * ユーザーのアカウント（公開用）.
     */
    public function openAccounts(): Collection
    {
        return $this->accounts()
            ->where('locked', false)
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function statuses(): HasManyThrough
    {
        return $this->hasManyThrough(Status::class, Account::class);
    }
}
