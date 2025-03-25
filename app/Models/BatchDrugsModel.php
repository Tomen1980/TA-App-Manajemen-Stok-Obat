<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchDrugsModel extends Model
{
    protected $table = "batch_drugs";
    protected $fillable = [
        'no_batch',
        'production_date',
        'expired_date',
        'batch_stock',
        'purchase_price',
        'medicine_id'
    ];
    public $timestamps = true;
}
