<?php

namespace Features\User\Models;

use Features\Core\Models\Account;
use Features\Core\Models\CreditCart;
use Features\Core\Models\Transaction;
use Features\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id');
    }

    // pr many dep
    // en
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            CreditCart::class,
            'user_id',
            'cart_id',
            'id',
            'id'
        );
    }

    public static function newFactory()
    {
        return UserFactory::new();
    }
}
