<?php

namespace Features\Core\Models;

use Features\Core\Database\Factories\CreditCartFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string cart_number
 * @property string cvv2
 * @property string expired_at
 *
 * @property HasMany transactions
 * @property BelongsTo account
 */
class CreditCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_number',
        'account_id',
        'cvv2',
        'expired_at',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'cart_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public static function newFactory()
    {
        return CreditCartFactory::class;
    }
}
