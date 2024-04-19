<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PostsUserMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_user_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('post_id');
            $table->unsignedTinyInteger('user_id');
            $table->unsignedTinyInteger('is_post_read_by_user')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_user_mapping');
    }
}
