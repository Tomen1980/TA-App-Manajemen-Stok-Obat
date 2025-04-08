<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicineMasterModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function medicineMaster(): BelongsTo{
        return $this->belongsTo(MedicineMasterModel::class,'medicine_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($batch) {
            $medicine = MedicineMasterModel::find($batch->medicine_id);
            if ($medicine) {
                $medicine->increment('stock', $batch->batch_stock);
            }
        });

        static::updated(function ($batch) {
            $oldBatch = $batch->getOriginal();
            $medicine = MedicineMasterModel::find($batch->medicine_id);
            if ($medicine) {
                $medicine->increment('stock', $batch->batch_stock - $oldBatch['batch_stock']);
            }
        });

        static::deleted(function ($batch) {
            $medicine = MedicineMasterModel::find($batch->medicine_id);
            if ($medicine) {
                $medicine->decrement('stock', $batch->batch_stock);
            }
        });
    }
}
