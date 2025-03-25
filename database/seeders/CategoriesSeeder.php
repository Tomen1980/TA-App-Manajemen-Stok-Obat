<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryModel::create([
            "name" => "Obat Bebas"
        ]);
        CategoryModel::create([
            "name" => "Obat Keras"
        ]);
        CategoryModel::create([
            "name" => "Obat Herbal"
        ]);
        CategoryModel::create([
            "name"=> "Obat Psikotropika/Narkotika"
        ]);
    }
}
