<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('slug');
            $table->json('title');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 9, 3)->nullable();
            $table->string('sku')->nullable();
            $table->integer('qty')->nullable()->default(1);
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean("pending_for_approval")->default(false);
            $table->integer("sort")->default(0);
            $table->text("shipment")->nullable();
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
        Schema::dropIfExists('products');
    }
}
