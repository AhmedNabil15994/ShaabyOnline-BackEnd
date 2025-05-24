<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInternalLinkToAdvertisingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertising', function (Blueprint $table) {
            $table->bigInteger('advertable_id')->nullable()->after('end_at');
            $table->string('advertable_type')->nullable()->after('advertable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertising', function (Blueprint $table) {
            $table->dropColumn(['advertable_id', 'advertable_type']);
        });
    }
}
