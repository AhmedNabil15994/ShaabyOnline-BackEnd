<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAddonOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_addon_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_addon_id')->unsigned();
            $table->bigInteger('addon_option_id')->unsigned()->nullable();
            $table->boolean('default')->default(0);
            $table->foreign('product_addon_id')->references('id')->on('product_addons')->onDelete('cascade');
            $table->foreign('addon_option_id')->references('id')->on('addon_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_addon_options');
    }
}
