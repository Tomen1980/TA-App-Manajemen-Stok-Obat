<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicine_master', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->integer('price')->default(0);
            $table->text('description');
            $table->string('image');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_master_obat');
    }
};
