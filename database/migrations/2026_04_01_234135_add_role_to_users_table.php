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
    Schema::table('users', function (Blueprint $table) {
        // Kita tambah kolom role, default isinya 'pelanggan'
        $table->string('role')->default('pelanggan')->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Ini untuk menghapus kolom jika migration di-rollback
        $table->dropColumn('role');
    });
}
    
};
