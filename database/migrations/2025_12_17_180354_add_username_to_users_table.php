<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Menambahkan kolom username setelah kolom name
        // Dibuat nullable dulu agar tidak error pada data lama
        $table->string('username')->unique()->nullable()->after('name');
        
        // Opsional: Tambahkan kolom avatar & cover jika belum ada
        if (!Schema::hasColumn('users', 'avatar')) {
            $table->string('avatar')->nullable()->after('email');
        }
        if (!Schema::hasColumn('users', 'cover_image')) {
            $table->string('cover_image')->nullable()->after('avatar');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username', 'avatar', 'cover_image']);
    });
}
};
