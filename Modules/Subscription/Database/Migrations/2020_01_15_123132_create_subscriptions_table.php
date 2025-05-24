<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('original_price',9,3);
            $table->decimal('total',9,3);
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('status')->default(false);
            $table->timestamp('send_expiration_at')->nullable();
            $table->bigInteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages')->onUpdate('cascade');
            $table->bigInteger('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onUpdate('cascade');
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
        Schema::dropIfExists('subscriptions');
    }
}
