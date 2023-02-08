<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->string('google_id')->after('bio')->unique()->nullable();
            $table->string('google_token')->after('google_id');
            $table->string('google_refresh_token')->after('google_token')->nullable();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('google_id', 'google_token', 'google_refresh_token');
            $table->string('password')->nullable(false)->change();
        });
    }
};
