<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts_likes', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(User::class);


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts_likes');
    }
};
