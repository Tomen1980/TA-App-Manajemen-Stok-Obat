<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function batch_drugs():HasMany{
        return $this->hasMany(BatchDrugsModel::class,'medicine_id','id');
    }

    public function category(): HasOne{
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }

    public function supplier(): HasOne{
        return $this->hasOne(SupplierModel::class,'id','supplier_id');
    }
}
