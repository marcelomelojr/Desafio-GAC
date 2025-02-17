<?php

namespace App\Models;

use App\Enums\StatusTransactionEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $fillable = [
        'amount',
        'type',
        'payer_id',
        'payee_id',
        'status',
        'type',
    ];

    protected $casts = [
        'status' => StatusTransactionEnum::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function rollback()
    {
        return $this->hasOne(Rollback::class);
    }
}
