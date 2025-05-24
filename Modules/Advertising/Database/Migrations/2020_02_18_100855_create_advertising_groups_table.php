<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
    
            $table->boolean('status')->default(false);
            $table->integer("sort")->default(0);
            $table->string('position')->nullable()->comment('home|categories');
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
        Schema::dropIfExists('advertising_groups');
    }
}
