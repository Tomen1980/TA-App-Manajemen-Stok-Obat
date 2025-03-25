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
        Schema::create('transaction_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_drug_id')->unsigned();
            $table->foreign('batch_drug_id')->references('id')->on('batch_drugs')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('transaction_id')->unsigned()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaction')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('item_amount');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_transaction_item');
    }
};
