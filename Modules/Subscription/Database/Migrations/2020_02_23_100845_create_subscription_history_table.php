<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total',9,3);
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('subscription_history');
    }
}
