<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderVariantProductValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_variant_product_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_variant_product_id')->unsigned();
            $table->bigInteger('product_variant_value_id')->unsigned();

            $table->foreign('order_variant_product_id')->references('id')->on('order_variant_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_variant_value_id')->references('id')->on('product_variant_values')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_variant_product_values');
    }
}
