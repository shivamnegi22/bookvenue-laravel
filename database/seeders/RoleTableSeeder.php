<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;


class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 1. admin

        $role_admin = new Role();

        $role_admin->name = "admin";

        $role_admin->slug = 'admin';

        $role_admin->description = "A admin with admin privilege";

        $role_admin->permissions = json_encode([

            'create-user' => true,

            'view-user' => true,

            'edit-user' => true,

            'delete-user' => true,

            'assign-roles' => true,

            'create-vendor' => true,

            'view-vendor' => true,

            'edit-vendor' => true,

            'delete-vendor' => true,

            'view-profile' => true,

        ]);

        $role_admin->save();


        // 2. vendor

        $role_vendor = new Role();

        $role_vendor->name = "vendor";

        $role_vendor->slug = 'vendor';

        $role_vendor->description = "A vendor with vendor privilege";

        $role_vendor->permissions = json_encode([

            'view-profile' => true,

        ]);



        $role_vendor->save();

        // 3. helpdesk

        $role_helpdesk = new Role();

        $role_helpdesk->name = "helpdesk";

        $role_helpdesk->slug = 'helpdesk';

        $role_helpdesk->description = "A helpdesk with helpdesk privilege";

        $role_helpdesk->permissions = json_encode([

            'view-profile' => true,

        ]);

        $role_helpdesk->save();


        //mangaer

        $role_manager = new Role();

        $role_manager->name = "manager";

        $role_manager->slug = 'manager';

        $role_manager->description = "A manager with manager privilege";

        $role_manager->permissions = json_encode([

            'view-profile' => true,

        ]);
        

        $role_manager->save();

        // 4. user

        $role_user = new Role();

        $role_user->name = "user";

        $role_user->slug = 'user';

        $role_user->description = "A user with user privilege";

        $role_user->permissions = json_encode([

            'view-profile' => true,

        ]);

        $role_user->save();


    }
}
