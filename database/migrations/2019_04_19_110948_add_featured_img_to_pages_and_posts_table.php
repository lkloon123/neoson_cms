<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedImgToPagesAndPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->text('featured_img')->nullable()->default(null);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->text('featured_img')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('featured_img');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('featured_img');
        });
    }
}
