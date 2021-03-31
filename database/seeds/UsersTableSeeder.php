<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
            'user_type_id' => 1,
            'first_name' => 'WMU',
            'last_name' => 'Admin',
            'email' => 'admin@wmu.com',
            'password' => Hash::make('admin1234'),
            'phone' => 5454545454,
        ]);
    }
}
