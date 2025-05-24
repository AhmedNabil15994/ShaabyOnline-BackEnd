<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorCategoriesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_categories_pivot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_category_id')->unsigned();
            $table->foreign('vendor_category_id')->references('id')->on('vendor_categories')->onDelete('cascade');
            $table->bigInteger('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_categories_pivot');
    }
}
