<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Roles

        $role_admin = Role::find(1);

        $role_vender = Role::find(2);

        $role_helpdesk = Role::find(3);

        $role_user = Role::find(4);

        $role_manager = Role::find(5);


        // Admin

        $admin = new User();

        $admin->phone = "8532977853";

        $admin->save();

        $admin->roles()->attach($role_admin); 



        Profile::create([

            'user_id' => 1,
            'name' => 'Admin'
        ]);

        // vender

        $vender = new User();

        $vender->phone = "0000000000";

        $vender->save();

        $vender->roles()->attach($role_vender); 



        Profile::create([

            'user_id' => 2,
            'name' => 'vender'
        ]);



        // helpdesk

        $helpdesk = new User();

        $helpdesk->phone = "1111111111";

        $helpdesk->save();

        $helpdesk->roles()->attach($role_helpdesk); 



        Profile::create([

            'user_id' => 3,
            'name' => 'helpdesk'
        ]);


                // manager

                $manager = new User();

                $manager->phone = "8279472977";
        
                $manager->save();
        
                $manager->roles()->attach($role_manager); 
        
        
        
                Profile::create([
        
                    'user_id' => 5,
                    'name' => 'manager'
                ]);


        // user

        $user = new User();

        $user->phone = "1234567890";

        $user->save();

        $user->roles()->attach($role_user); 

        Profile::create([

            'user_id' => 4,
            'name' => 'user'
        ]);



    }
}
