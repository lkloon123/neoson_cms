<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->text('title');
            $table->text('slug');
            $table->bigInteger('parent_id')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->longText('content');
            $table->integer('status')->default(\App\Enums\PageStatus::Draft);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('expired_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
