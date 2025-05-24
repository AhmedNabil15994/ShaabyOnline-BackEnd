<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('unread')->default(false);
            $table->boolean('increment_qty')->nullable();
            $table->decimal('original_subtotal', 30, 3);
            $table->decimal('subtotal', 30, 3);
            $table->decimal('off', 30, 3)->default(0.000);
            $table->decimal('shipping', 30, 3)->default(0.000);
            $table->decimal('total', 30, 3);

//            $table->decimal('total_comission',30,3);
            $table->decimal('total_profit', 30, 3);
//            $table->decimal('total_profit_comission',30,3);

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');

//            $table->bigInteger('vendor_id')->unsigned();
//            $table->foreign('vendor_id')->references('id')->on('vendors')->onUpdate('cascade');

            $table->bigInteger('order_status_id')->unsigned();
            $table->foreign('order_status_id')->references('id')->on('order_statuses');

            $table->bigInteger('payment_status_id')->unsigned()->nullable();
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');

            $table->text('notes')->nullable();
            $table->text('order_notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
