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
            $table->string('lang')->default('en')->after('remember_token');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->string('lang')->default('en')->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lang');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
    }
};
