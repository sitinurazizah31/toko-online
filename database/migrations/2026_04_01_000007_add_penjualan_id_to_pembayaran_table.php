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
        Schema::table('pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran', 'penjualan_id')) {
                $table->unsignedInteger('penjualan_id')->nullable()->after('id');
                $table->index('penjualan_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'penjualan_id')) {
                $table->dropIndex(['penjualan_id']);
                $table->dropColumn('penjualan_id');
            }
        });
    }
};
