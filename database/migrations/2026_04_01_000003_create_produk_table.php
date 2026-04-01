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
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('ProdukID');
            $table->string('NamaProduk');
            $table->decimal('Harga', 15, 2)->default(0);
            $table->unsignedInteger('Stok')->default(0);
            $table->string('kategori')->nullable();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('total_terjual')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
