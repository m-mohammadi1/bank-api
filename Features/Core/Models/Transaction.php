<?php

namespace Features\Core\Models;

use Features\Core\Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int amount
 * @property boolean status
 *
 * @property HasOne wage
 * @property BelongsTo credit_cart
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'cart_id',
        'status',
    ];

    public function wage(): HasOne
    {
        return $this->hasOne(Wage::class);
    }

    public function credit_cart(): BelongsTo
    {
        return $this->belongsTo(CreditCart::class, 'cart_id');
    }

    public static function newFactory()
    {
        return TransactionFactory::class;
    }
}
