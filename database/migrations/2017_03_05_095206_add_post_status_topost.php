<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostStatusTopost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('nice_count')->default(0);
            $table->unsignedInteger('bad_count')->default(0);
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
            $table->dropColumn('view_count');
            $table->dropColumn('nice_count');
            $table->dropColumn('bad_count');
        });
    }
}
