<?php

namespace Database\Seeders;

use App\Enums\SupplierStatus;
use App\Models\SupplierModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierModel::create([
            "name"=> "PT. Sehat Sentosa Abadi",
            "address" => "Jl. Industri Raya No. 45, Jakarta Barat 11730",
            "contact" => "02155678901",
            "status" => SupplierStatus::APPROVE,
        ]);
        SupplierModel::create([
            "name"=> "CV. Farma Makmur Jaya",
            "address" => "Komplek Pergudangan Permata Blok B-12, Bandung 40293",
            "contact" => "081234567890",
            "status" => SupplierStatus::APPROVE,
        ]);
        SupplierModel::create([
            "name"=> "UD. Bintang Farma",
            "address" => "Jl. Raya Kesehatan No. 88, Surabaya 60189",
            "contact" => "082345678901",
            "status" => SupplierStatus::APPROVE,
        ]);
        SupplierModel::create([
            "name"=> "PT. Global Medika Prima",
            "address" => "Gedung Medika Tower Lt. 5, Jl. Sudirman Kav. 25, Jakarta Selatan 12920",
            "contact" => "02178901234",
            "status" => SupplierStatus::APPROVE,
        ]);
        SupplierModel::create([
            "name"=> " CV. Sumber Sehat Farmasi",
            "address" => "Jl. Pahlawan Kesehatan No. 10, Semarang 50123",
            "contact" => "085678901234",
            "status" => SupplierStatus::APPROVE,
        ]);
    }
}
