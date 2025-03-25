<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    protected $table = "transaction";
    protected $fillable = [
        "type",
        "total_price",
        "date",
        "user_id"
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'type' => TransactionType::class
        ];
    }
}
