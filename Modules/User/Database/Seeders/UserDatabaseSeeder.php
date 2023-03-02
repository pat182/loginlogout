<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\{User,UserProfile};

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = User::create(
                [
                        'username' => 'superadmin',
                        'email' => 'patrick.chua182@gmail.com',
                        "permission_type_id" => 1,
                        "password" => bcrypt("test123!@#")
                    ]
        );
       
        $profile = UserProfile::create([
            'user_id' => $user->user_id,
            'f_name' => 'patrick',
            'l_name' => 'chua'
        ]);  
       
    }
}
