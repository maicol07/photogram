<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->text('description')->default('')->change();
        });
    }

    public function down(): void
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
};
