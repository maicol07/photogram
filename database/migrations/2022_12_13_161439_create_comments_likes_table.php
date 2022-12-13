<?php

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comments_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Comment::class);
            $table->foreignIdFor(User::class);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments_likes');
    }
};
