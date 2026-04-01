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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('produk');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('metode');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status')->default('menunggu');
            $table->timestamps();
        });

        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('metode');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('keranjang', function (Blueprint $table) {
            $table->increments('KeranjangID');
            $table->unsignedInteger('PelangganID');
            $table->unsignedInteger('ProdukID');
            $table->unsignedInteger('jumlah')->default(1);
            $table->timestamps();

            $table->index('PelangganID');
            $table->index('ProdukID');
        });

        Schema::create('wishlist', function (Blueprint $table) {
            $table->increments('WishlistID');
            $table->unsignedInteger('PelangganID');
            $table->unsignedInteger('ProdukID');
            $table->timestamps();

            $table->index('PelangganID');
            $table->index('ProdukID');
            $table->unique(['PelangganID', 'ProdukID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('pengiriman');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('pesanan');
    }
};
