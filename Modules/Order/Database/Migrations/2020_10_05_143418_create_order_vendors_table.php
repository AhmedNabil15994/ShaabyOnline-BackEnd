<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('vendor_id')->unsigned();
            $table->decimal('total_comission', 30, 3)->nullable();
            $table->decimal('total_profit_comission', 30, 3)->nullable();
            $table->decimal('original_subtotal', 30, 3);
            $table->decimal('subtotal', 30, 3);
            $table->unsignedBigInteger("qty")->default(0)->nullable();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_vendors');
    }
}
