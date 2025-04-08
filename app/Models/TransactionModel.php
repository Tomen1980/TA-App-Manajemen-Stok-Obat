<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionModel extends Model
{
    protected $table = "transaction";
    protected $fillable = [
        "type",
        "total_price",
        "date",
        "status",
        "user_id"
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'type' => TransactionType::class,
        ];
    }

    public function user():HasOne{
        return $this->hasOne(User::class,'id','user_id');
    }

    public function transactionsItem(): HasMany {
        return $this->hasMany(TransactionItemModel::class,'transaction_id','id');
    }

  
}
