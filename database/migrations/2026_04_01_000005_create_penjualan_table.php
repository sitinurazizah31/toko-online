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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('PenjualanID');
            $table->unsignedInteger('PelangganID')->nullable();
            $table->date('TanggalPenjualan')->nullable();
            $table->decimal('TotalHarga', 15, 2)->default(0);
            $table->string('status_pembayaran')->default('belum_bayar');
            $table->string('status_pesanan')->default('diproses');
            $table->timestamps();

            $table->index('PelangganID');
            $table->index('TanggalPenjualan');
            $table->index('status_pembayaran');
            $table->index('status_pesanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
