<?php

namespace Database\Seeders;

use App\Models\BatchDrugsModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchDrugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2028-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 2
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2024-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 2
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2026-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 3
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2024-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 4
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2024-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 5
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan15",
            'production_date' => "2015-01-01",
            'expired_date' => "2023-01-01",
            'batch_stock' => 100,
            'purchase_price' => 10000,
            'medicine_id' => 5
        ]);
        BatchDrugsModel::create([
            "no_batch" => "12Jan14",
            'production_date' => "2023-01-01",
            'expired_date' => "2024-01-01",
            'batch_stock' => 50,
            'purchase_price' => 10000,
            'medicine_id' => 6
        ]);
    }
}
