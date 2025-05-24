<?php

use Illuminate\Database\Migrations\Migration;
use Modules\User\Entities\User;

class ChangeTocaanPermToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $super_admins = User::whereIn('email',
        ['admin@admin.com','admin@tocaan.com','ahmed@tocaan.com','dev@tocaan.com'])->get();

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
        //
    }
}
