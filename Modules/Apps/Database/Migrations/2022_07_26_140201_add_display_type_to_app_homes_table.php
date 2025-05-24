<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayTypeToAppHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_homes', function (Blueprint $table) {
            $table->string("display_type")->nullable()->default('carousel')->after('type');
            $table->integer("grid_columns_count")->nullable()->after('display_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_homes', function (Blueprint $table) {
            $table->dropColumn(["display_type", "grid_columns_count"]);
        });
    }
}
