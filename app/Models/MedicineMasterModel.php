<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineMasterModel extends Model
{
    protected $table = "medicine_master";
    protected $fillable = [
        'name',
        'stock',
        'min_stock',
        'price',
        'description',
        'image',
        'category_id',
        'supplier_id',
    ];

    public $timestamps = true;
}
