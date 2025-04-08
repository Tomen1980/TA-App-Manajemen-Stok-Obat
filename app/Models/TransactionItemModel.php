<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionItemModel extends Model
{
    protected $table = "transaction_item";

    protected $fillable = [
        'batch_drug_id',
        'transaction_id',
        'item_amount',
        'total_price',
    ];

    public $timestamps = true;

    public function transactions():BelongsTo{
        return $this->belongsTo(TransactionModel::class,'transaction_id','id');
    }

    public function batchDrug():HasOne{
        return $this->hasOne(BatchDrugsModel::class,'id','batch_drug_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $transaction = TransactionModel::find($item->transaction_id);
            if ($transaction) {
                $transaction->increment('total_price', $item->total_price);
            }
        });

        static::deleted(function ($item) {
            $transaction = TransactionModel::find($item->transaction_id);
            if ($transaction) {
                $transaction->decrement('total_price', $item->total_price);
            }
        });
    }
}
