<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class)
            ->using(StatusTag::class)
            ->withTimestamps();
    }
}
