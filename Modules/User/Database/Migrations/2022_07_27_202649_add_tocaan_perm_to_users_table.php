<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\User\Entities\User;

class AddTocaanPermToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->boolean('tocaan_perm')->default(false);
        });

        $super_admins = User::whereIn('email',['admin@admin.com','admin@tocaan.com','ahmed@tocaan.com'])->get();

        if($super_admins->count()){
            foreach($super_admins as $super_admin){

                $super_admin->tocaan_perm = true;
                $super_admin->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tocaan_perm']);
        });
    }
}
