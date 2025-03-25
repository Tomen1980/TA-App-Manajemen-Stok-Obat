<?php

namespace Database\Seeders;

use App\Models\MedicineMasterModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicineMasterModel::create([
            "name" => "Paracetamol",
            "stock" => 0,
            "min_stock" => 10,
            "price" => 10000,
            "image"=>"https://images.unsplash.com/photo-1622227922682-56c92e523e58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "description" => "Obat untuk sakit kepala",
            "category_id" => 1,
            "supplier_id"=> 1,
        ]);

        MedicineMasterModel::create([
            "name" => "Amoxicillin",
            "stock" => 0,
            "min_stock" => 10,
            "price" => 10000,
            "description" => "Mengobati infeksi bakteri seperti radang tenggorokan, infeksi saluran kemih, atau pneumonia.",
            "image"=>"https://images.unsplash.com/photo-1622227922682-56c92e523e58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "category_id" => 2,
            "supplier_id"=> 2,
        ]);

        MedicineMasterModel::create([
            "name" => "Omeprazole",
            "stock" => 0,
            "min_stock" => 10,
            "price" => 10000,
            "description" => "Mengurangi asam lambung untuk mengobati maag, GERD, atau tukak lambung.",
            "image"=>"https://images.unsplash.com/photo-1622227922682-56c92e523e58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "category_id" => 3,
            "supplier_id"=> 3
        ]);

        MedicineMasterModel::create([
            "name" => "Antalgin",
            "stock" => 0,
            "min_stock" => 10,
            "price" => 10000,
            "description" => "Pereda nyeri kuat (sakit gigi, nyeri otot) dan penurun demam.",
            "image"=>"https://images.unsplash.com/photo-1622227922682-56c92e523e58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "category_id" => 4,
            "supplier_id"=> 4
            ]);
        
        MedicineMasterModel::create([
            "name" => "Diazepam",
            "stock" => 0,
            "min_stock" => 10,
            "price" => 10000,
            "description" => "Mengatasi kecemasan, kejang, atau relaksan otot.",
            "image"=>"https://images.unsplash.com/photo-1622227922682-56c92e523e58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "category_id" => 4,
            "supplier_id"=> 4
            ]);


    }
}
