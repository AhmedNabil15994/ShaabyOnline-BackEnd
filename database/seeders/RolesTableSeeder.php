<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\Entities\Role;
use Modules\Authorization\Entities\Permission;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;

class RolesTableSeeder extends Seeder
{

    private $roles = [
        'admins' => [
            'title_en' => 'Super Admin',
            'title_ar' => 'لوحة التحكم الموظفين',
        ],
        'vendors' => [
            'title_en' => 'Vendors',
            'title_ar' => 'لوحة تحكم المتاجر',
        ],
        'drivers' => [
            'title_en' => 'Drivers',
            'title_ar' => 'لوحة تحكم السائقين',
        ],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        (new PermissionsTableSeeder())->run();

        foreach ($this->roles as $name => $role_data) {

            $role = Role::updateOrCreate([
                'name' => $name,
            ], [
                'name' => $name,
                'display_name' => ['en' => $role_data['title_en'], 'ar' => $role_data['title_ar']]
            ]);

            if ($name == 'admins') {
                DB::table('permission_role')->where('role_id', $role->id)->delete();
                foreach (Permission::whereNotIn('name', ['seller_access', 'driver_access'])->get() as $permission) {
                    $role->attachPermission($permission->id);
                }
                User::find(1)->roles()->sync([$role->id]);
            } elseif ($name == 'drivers') {
                DB::table('permission_role')->where('role_id', $role->id)->delete();
                $permission = Permission::where('name', 'driver_access')->first();
                $role->attachPermission($permission->id);
                User::find(3)->roles()->sync([$role->id]); // test driver
            } elseif ($name == 'vendors') {
                DB::table('permission_role')->where('role_id', $role->id)->delete();
                $permission = Permission::where('name', 'seller_access')->first();
                $role->attachPermission($permission->id);
                User::find(2)->roles()->sync([$role->id]); // test seller
            }
        }

        DB::commit();
    }
}
