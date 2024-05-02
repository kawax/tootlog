<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $perPage = 20;

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
    protected $appends = [
        'local_datetime',
        'name',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function acct(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->account->username.'@'.parse_url($this->account->url, PHP_URL_HOST),
        );
    }

    /**
     * 表示用の名前.
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->account->name ?? '',
        );
    }

    public function localDatetime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at,
        );
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function reblog(): BelongsTo
    {
        return $this->belongsTo(Reblog::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
