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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_name');
            $table->text('shipping_address');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processed', 'shipped', 'delivered'])->default('pending');
            $table->enum('courier', ['jne', 'tiki', 'pos']) // Menambahkan kolom kurir
                ->default('jne'); // Default ke JNE
            $table->string('tracking_number')->nullable(); // Menyimpan nomor resi pengiriman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
