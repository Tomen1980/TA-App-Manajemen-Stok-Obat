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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in','out'])->default('in');
            $table->integer('total_price')->default(0);
            $table->date('date');
            $table->enum('status',['arrears','paid'])->default('arrears');
            $table->bigInteger('user_id')->unsigned()->nullable(); // Pastikan tipe data sesuai
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_transaction');
    }
};
