<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('email')->nullable();
            $table->text('username')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->longText('block')->nullable();
            $table->longText('street')->nullable();
            $table->longText('building')->nullable();
            $table->longText('address')->nullable();
            $table->bigInteger('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('addresses');
    }
}
