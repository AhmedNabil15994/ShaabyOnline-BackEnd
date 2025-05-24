<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('slug');
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('image');
            $table->integer('sorting')->default(0);
            $table->integer('status')->default(false);
            $table->boolean('is_new')->default(false);
            $table->string('vendor_email')->nullable();
            $table->integer('vendor_status_id')->unsigned()->nullable();
            $table->foreign('vendor_status_id')->references('id')->on('vendor_statuses')->onDelete('cascade');
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
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
        Schema::dropIfExists('vendors');
    }
}
