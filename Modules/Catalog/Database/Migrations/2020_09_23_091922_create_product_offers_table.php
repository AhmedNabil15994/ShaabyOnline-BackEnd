<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('status')->default(false);
            $table->decimal('offer_price', 9, 3)->nullable();
            // $table->integer('percentage')->nullable();
            $table->decimal('percentage', 9, 3)->nullable();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_offers');
    }
}
