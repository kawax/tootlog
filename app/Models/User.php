<?php

namespace App\Models;

use App\Models\Concerns\WithUserAccount;
use App\Models\Concerns\WithUserArchives;
use App\Models\Concerns\WithUserStatus;
use App\Models\Concerns\WithUserTag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use WithUserAccount;
    use WithUserStatus;
    use WithUserArchives;
    use WithUserTag;

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

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function statuses(): HasManyThrough
    {
        return $this->hasManyThrough(Status::class, Account::class);
    }
}
