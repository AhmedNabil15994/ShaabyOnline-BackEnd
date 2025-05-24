<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('slug')->nullable();
            $table->json('title');
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            // $table->string('slug')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->string("color", 50)->nullable();
            $table->integer("sort")->default(0);

            $table->foreign('category_id')->references('id')->on('categories')
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
        Schema::dropIfExists('categories');
    }
}
