<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'app_id',
        'domain',
        'redirect_uri',
        'client_id',
        'client_secret',
        'version',
        'streaming',
    ];

    /**
     * streaming api url.
     */
    public function streaming(): Attribute
    {
        return Attribute::make(
            get: function ($streaming) {
                if (! is_null($streaming)) {
                    return $streaming;
                }

                $domain = data_get(config('tootlog.streaming', []), $this->domain, $this->domain);

                return str_replace('http', 'ws', $domain);
            },
        );
    }

    public function favicon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->domain.'/'.data_get(config('tootlog.favicon', []), $this->domain, 'favicon.ico'),
        );
    }

    /**
     * @return HasMany<Account, $this>
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
