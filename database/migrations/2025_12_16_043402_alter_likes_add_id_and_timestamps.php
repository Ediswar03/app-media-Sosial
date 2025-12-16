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
    Schema::table('likes', function (Blueprint $table) {
        if (!Schema::hasColumn('likes', 'id')) {
            $table->id()->first();
        }

        if (!Schema::hasColumn('likes', 'created_at')) {
            $table->timestamps();
        }
    });
}

public function down(): void
{
    Schema::table('likes', function (Blueprint $table) {
        $table->dropColumn(['id', 'created_at', 'updated_at']);
    });
}

};
