<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('slug')->nullable();
            $table->json('title')->nullable();
            $table->string("image")->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->unsignedBigInteger("sort")->default(1);
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
        Schema::dropIfExists('home_categories');
    }
}
