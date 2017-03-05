<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //https://laravel10.wordpress.com/2015/03/30/%E5%88%9D%E3%82%81%E3%81%A6%E3%81%AElaravel-5-33-%E5%A4%9A%E5%AF%BE%E5%A4%9A%E3%81%AE%E3%83%AA%E3%83%AC%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3-%E3%83%A2%E3%83%87%E3%83%ABdb%E7%B7%A8/
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('post_tag', function(Blueprint $table) {
            $table->timestamps();
            $table->integer('post_id')->unsigned()->index();
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');

            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('tags');
        Schema::dropIfExists('post_tag');
    }
}
