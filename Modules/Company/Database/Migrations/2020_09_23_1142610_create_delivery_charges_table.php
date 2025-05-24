<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('delivery', 9, 3)->nullable();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['company_id', 'state_id']);
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
        Schema::dropIfExists('delivery_charges');
    }
}
