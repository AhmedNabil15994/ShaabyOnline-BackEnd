<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorIdToOrderVariantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_variant_products', function (Blueprint $table) {
            $table->bigInteger('vendor_id')->unsigned()->nullable()->after('order_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
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
            $table->dropForeign('order_variant_products_vendor_id_foreign');
            $table->dropIndex('order_variant_products_vendor_id_foreign');
            $table->dropColumn(['vendor_id']);
        });
    }
}
