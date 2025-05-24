<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraMobileVerificationFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firebase_uuid')->nullable()->unique()->after('remember_token');
            $table->string("code_verified", 30)->nullable()->after('firebase_uuid');
            $table->boolean('is_verified')->default(false)->after('code_verified');
            $table->text("setting")->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['firebase_uuid', 'code_verified', 'is_verified', 'setting']);
        });
    }
}
