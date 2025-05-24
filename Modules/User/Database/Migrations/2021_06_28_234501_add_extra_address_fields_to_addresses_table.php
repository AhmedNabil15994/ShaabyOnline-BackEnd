<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraAddressFieldsToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('avenue')->nullable()->after('user_id');
            $table->string('floor', 50)->nullable()->after('avenue');
            $table->string('flat', 50)->nullable()->after('floor');
            $table->string('automated_number', 50)->nullable()->after('flat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['avenue', 'floor', 'flat', 'automated_number']);
        });
    }
}
