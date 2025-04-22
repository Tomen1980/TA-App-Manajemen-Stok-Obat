<?php

namespace App\Models;

use App\Enums\SupplierStatus;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = "supplier";
    protected $fillable = [
        'name',
        'address',
        'contact',
        // 'status'
    ];

    public $timestamps = true;

    protected function casts(): array
        {
            return [
                'status' => SupplierStatus::class
            ];
        }
    
}
