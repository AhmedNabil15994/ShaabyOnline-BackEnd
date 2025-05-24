<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_addons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('addon_category_id')->unsigned()->nullable();
            $table->enum('type', ['single', 'multi']);
            $table->integer('min_options_count')->nullable();
            $table->integer('max_options_count')->nullable();
            $table->boolean("is_required")->default(0)->comment('if it is equal true, user should add at least one addon options to cart');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('addon_category_id')->references('id')->on('addon_categories')->onDelete('cascade');
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
        Schema::dropIfExists('product_addons');
    }
}
