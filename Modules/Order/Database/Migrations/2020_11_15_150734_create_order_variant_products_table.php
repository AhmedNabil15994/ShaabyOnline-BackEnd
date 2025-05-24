<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderVariantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_variant_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_variant_id')->unsigned();

            $table->decimal('sale_price', 9, 3);
            $table->decimal('price', 9, 3);
            $table->decimal('off', 9, 3)->default(0.000);
            $table->integer('qty')->default(1);
            $table->decimal('total', 9, 3);
            $table->decimal('original_total', 9, 3);
            $table->decimal('total_profit', 9, 3);
            $table->text('notes')->nullable();
            $table->text('add_ons_option_ids')->nullable();

            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('order_variant_products');
    }
}
