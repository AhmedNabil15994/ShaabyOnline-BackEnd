<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('result')->nullable();
            $table->string('post_date')->nullable();
            $table->string('ref')->nullable();
            $table->string('track_id')->nullable();
            $table->string('auth')->nullable();
            $table->morphs('transaction');
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
        Schema::dropIfExists('transactions');
    }
}
