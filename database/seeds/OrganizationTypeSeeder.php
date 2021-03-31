<?php

use Illuminate\Database\Seeder;

use App\Models\OrganizationType;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationType::create([
            'name' => 'Health and Wellness',
            'last_modified_by' => 1,
        ]);

        OrganizationType::create([
            'name' => 'Education',
            'last_modified_by' => 1,
        ]);

        OrganizationType::create([
            'name' => 'Athletics',
            'last_modified_by' => 1,
        ]);

        OrganizationType::create([
            'name' => 'Business and Organizations',
            'last_modified_by' => 1,
        ]);
    }
}
