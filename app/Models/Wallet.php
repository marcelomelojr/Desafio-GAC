<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //

    protected $fillable = [
        'balance',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function credit($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function debit($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }

//    public function balance(): Attribute
//    {
//        return Attribute::make(
//            get: fn ($value) => $value,
//            set: fn ($value) => ['balance' => $value * 100] // Armazena em centavos
//        );
//    }

}
