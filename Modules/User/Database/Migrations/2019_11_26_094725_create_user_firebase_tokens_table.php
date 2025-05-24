<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFirebaseTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_firebase_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->text('firebase_token');
            $table->integer('device_type'); // 1 for android, 2 for ios, 3 for web
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
        Schema::dropIfExists('user_firebase_tokens');
    }
}
