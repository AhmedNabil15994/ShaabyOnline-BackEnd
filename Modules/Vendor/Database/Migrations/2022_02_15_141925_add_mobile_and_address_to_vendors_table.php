<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileAndAddressToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('calling_code', 10)->nullable()->after('section_id');
            $table->string('mobile', 30)->unique()->nullable()->after('calling_code');
            $table->json('address')->nullable()->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['calling_code', 'mobile', 'address']);
        });
    }
}
