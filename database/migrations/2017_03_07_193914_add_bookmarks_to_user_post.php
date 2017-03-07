<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBookmarksToUserPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('bookmark_post', function(Blueprint $table) {
            $table->timestamps();
            $table->integer('bookmark_id')->unsigned()->index();
            $table->foreign('bookmark_id')
                ->references('id')->on('bookmarks')
                ->onDelete('cascade');

            $table->integer('post_id')->unsigned()->index();
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('bookmark_post');
    }
}
