<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DropProductForeignKeyInOrderProductsTable extends Migration
{
    protected $foreignKeyName = 'order_products_product_id_foreign';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keyExists = DB::select(
            DB::raw(
                "SHOW KEYS
                FROM order_products
                WHERE Key_name='{$this->foreignKeyName}'"
            )
        );

        Schema::table('order_products', function (Blueprint $table) use ($keyExists) {
            if (!empty($keyExists)) {
                $table->dropForeign($this->foreignKeyName);
                $table->dropIndex($this->foreignKeyName);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            /* $table->bigInteger('product_id')->unsigned()->nullable()->after('order_id');
            $table->foreign('product_id')->references('id')->on('products'); */
        });
    }
}
