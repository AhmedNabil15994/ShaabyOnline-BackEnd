<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_homes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('short_title')->nullable();
            $table->json('description')->nullable();
            $table->integer('status')->default(1);
            $table->integer('order')->nullable();
            $table->string('type');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
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
        Schema::dropIfExists('app_homes');
    }
}
