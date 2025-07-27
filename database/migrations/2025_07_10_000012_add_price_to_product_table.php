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
    Schema::table('products', function (Blueprint $table) {
        // Menambahkan kolom harga setelah kolom 'description'
        // Tipe data decimal cocok untuk uang. 15 digit total, 2 digit di belakang koma.
        // nullable() berarti boleh kosong, default(0) berarti nilai awalnya 0.
        $table->decimal('price', 15, 2)->nullable()->default(0)->after('description');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('price');
    });
}
};
