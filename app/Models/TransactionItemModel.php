<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    
}
