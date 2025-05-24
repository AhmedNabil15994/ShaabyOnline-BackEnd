<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_category_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->string("color", 50)->nullable();
            $table->integer("sort")->default(0);
            $table->json('slug');
            $table->json('title');
            $table->foreign('vendor_category_id')->references('id')->on('vendor_categories')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_categories');
    }
}
