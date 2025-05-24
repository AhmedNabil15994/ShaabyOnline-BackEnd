<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('addon_category_id')->unsigned()->nullable();
            $table->json('title');
            $table->float('price', 8, 2)->default(0);
            $table->integer('qty')->nullable();
            $table->string('image')->nullable();
            $table->foreign('addon_category_id')->references('id')->on('addon_categories')->onDelete('cascade');
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
        Schema::dropIfExists('addon_options');
    }
}
