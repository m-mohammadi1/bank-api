<?php

namespace Features\Core\Models;

use Features\Core\Database\Factories\WageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int amount
 *
 * @property BelongsTo transaction
 */
class Wage extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'transaction_id',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public static function newFactory()
    {
        return WageFactory::new();
    }
}
