<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@itsolutionstuff.com',
               'category'=>'proffesor',
                'is_admin'=>'1',
               'password'=> bcrypt('123456'),
               ''
            ],
            [
               'name'=>'User',
               'email'=>'user@itsolutionstuff.com',
               'category'=>'student',
                'is_admin'=>'0',
               'password'=> bcrypt('123456'),
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
