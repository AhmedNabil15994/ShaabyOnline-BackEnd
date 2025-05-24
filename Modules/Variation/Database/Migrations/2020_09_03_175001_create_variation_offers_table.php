<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('status')->default(false);
            $table->decimal('offer_price',9,3)->nullable();
            $table->integer('percentage')->nullable();
            $table->bigInteger('product_variant_id')->unsigned();
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');

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
        Schema::dropIfExists('variation_offers');
    }
}
