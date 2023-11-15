<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Profile;

class userTableSeeder extends Seeder
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

        $role_vendor = Role::find(2);

        $role_helpdesk = Role::find(3);

        $role_user = Role::find(4);

        $role_manager = Role::find(5);


        // admin

        $admin = new user();

        $admin->phone = "9999999999";

        $admin->password = bcrypt("Giks@123");

        $admin->save();

        $admin->roles()->attach($role_admin); 



        Profile::create([

            'user_id' => 1,
            'name' => 'admin'
        ]);

        // vendor

        $vendor = new user();

        $vendor->phone = "0000000000";

        $vendor->save();

        $vendor->roles()->attach($role_vendor); 



        Profile::create([

            'user_id' => 2,
            'name' => 'vendor'
        ]);



        // helpdesk

        $helpdesk = new user();

        $helpdesk->phone = "1111111111";

        $helpdesk->save();

        $helpdesk->roles()->attach($role_helpdesk); 



        Profile::create([

            'user_id' => 3,
            'name' => 'helpdesk'
        ]);


                // manager

                $manager = new user();

                $manager->phone = "8279472977";
        
                $manager->save();
        
                $manager->roles()->attach($role_manager); 
        
        
        
                Profile::create([
        
                    'user_id' => 5,
                    'name' => 'manager'
                ]);


        // user

        $user = new user();

        $user->phone = "1234567890";

        $user->save();

        $user->roles()->attach($role_user); 

        Profile::create([

            'user_id' => 4,
            'name' => 'user'
        ]);



    }
}
