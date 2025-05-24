<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_delivery_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('delivery', 9, 3)->nullable();
            $table->json('delivery_time')->nullable();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->decimal('min_order_amount', 30, 3)->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['vendor_id', 'state_id']);
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
        Schema::dropIfExists('vendor_delivery_charges');
    }
}
