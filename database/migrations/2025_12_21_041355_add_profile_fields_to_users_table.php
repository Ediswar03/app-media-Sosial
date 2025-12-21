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
            $table->string('address')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('address');
            $table->string('pekerjaan')->nullable()->after('phone');
            $table->string('education')->nullable()->after('pekerjaan');
            $table->string('location')->nullable()->after('education');
            $table->string('job_title')->nullable()->after('location');
            $table->string('company')->nullable()->after('job_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'pekerjaan', 'education', 'location', 'job_title', 'company']);
        });
    }
};
