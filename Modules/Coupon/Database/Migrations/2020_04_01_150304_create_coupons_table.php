<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->json('title')->nullable();
            $table->string('discount_type');
            $table->double('discount_percentage')->nullable();
            $table->double('discount_value')->nullable();
            $table->double('max_discount_percentage_value')->nullable();
            $table->integer('max_users')->nullable();
            $table->integer('user_max_uses')->nullable();
            $table->date('start_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->string('custom_type')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('coupons');
    }
}
