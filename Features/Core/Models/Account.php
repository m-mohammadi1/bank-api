<?php

namespace Features\Core\Models;

use Features\Core\Database\Factories\AccountFactory;
use Features\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string account_number
 *
 * @property BelongsTo user
 * @property HasMany credit_carts
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'balance',
        'user_id',
    ];

    public static function newFactory()
    {
        return AccountFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function credit_carts(): HasMany
    {
        return $this->hasMany(CreditCart::class, 'account_id');
    }

}
