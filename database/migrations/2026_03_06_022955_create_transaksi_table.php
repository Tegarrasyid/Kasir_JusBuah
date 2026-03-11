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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('kode_transaksi', 30)->unique();
            $table->enum('metode_pembayaran', ["tunai", "debit", "qris"]);
            $table->decimal('total_harga', 12, 2);
            $table->decimal('total_bayar', 12, 2);
            $table->decimal('nominal_bayar', 12, 2)->nullable();
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('status', ["selesai", "dibatalkan"]);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
