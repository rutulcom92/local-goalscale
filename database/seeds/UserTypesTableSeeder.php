<?php

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'name' => 'Admin',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

         UserType::create([
            'name' => 'Supervisor',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        UserType::create([
            'name' => 'Provider',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        UserType::create([
            'name' => 'Participant',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
