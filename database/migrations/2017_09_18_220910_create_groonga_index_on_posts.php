<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class CreateGroongaIndexOnPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION pgroonga');
        Schema::table('posts', function (Blueprint $table) {
            $table->text('title')->default('無題')->change();
            $table->index(['id', 'title', 'text'], 'post_search_index', 'pgroonga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title')->default('無題')->change();
            $table->dropIndex('post_search_index');
        });
        DB::statement('DROP EXTENSION pgroonga');
    }
}
