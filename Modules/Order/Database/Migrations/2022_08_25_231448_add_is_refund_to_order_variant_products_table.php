<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRefundToOrderVariantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_variant_products', function (Blueprint $table) {
            $table->boolean("is_refund")
                ->index()
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_variant_products', function (Blueprint $table) {
            $table->dropColumn(["is_refund"]);
        });
    }
}
