<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->json('title');
            $table->json('description');
            $table->json('slug');
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->integer('status')->default(1);
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')
                  ->references('id')->on('pages')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('pages');
    }
}
