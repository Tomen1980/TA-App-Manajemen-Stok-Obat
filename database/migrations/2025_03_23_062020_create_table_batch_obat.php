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
        Schema::create('batch_drugs', function (Blueprint $table) {
            $table->id();
            $table->string('no_batch');
            $table->date('production_date');
            $table->date('expired_date');
            $table->integer('batch_stock');
            $table->integer('purchase_price');
            $table->bigInteger('medicine_id')->unsigned();
            $table->foreign('medicine_id')->references('id')->on('medicine_master')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_batch_obat');
    }
};
