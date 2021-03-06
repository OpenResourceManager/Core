<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;

/**
 * Class UserRoleSeeder
 */
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::table(config('access.assigned_roles_table'))->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.assigned_roles_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.assigned_roles_table') . ' CASCADE');
        }

        //Attach admin role to admin user
        $admin = User::where('name', 'The Admin')->get()->first();
        $admin->attachRole(Role::first()->id);

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}