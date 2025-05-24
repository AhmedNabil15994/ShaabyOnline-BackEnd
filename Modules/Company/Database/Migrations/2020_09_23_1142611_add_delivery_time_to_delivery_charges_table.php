<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryTimeToDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->json('delivery_time')->nullable()->after('delivery');
            $table->boolean('status')->default(false)->after('delivery_time');
            $table->decimal('min_order_amount', 30, 3)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->dropColumn(['delivery_time', 'status', 'min_order_amount']);
        });
    }
}
