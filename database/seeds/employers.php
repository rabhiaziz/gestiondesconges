<?php

use Illuminate\Database\Seeder;
use App\Modules\Employer\Models\Role;
use App\Modules\Employer\Models\Employer;

class employers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'role' => 'Admin',
        ]);

        Role::create([
            'role' => 'Pas admin',
        ]);

        Employer::create([
            'name' => 'test 1',
            'role_id' => 1,
        ]);

        Employer::create([
            'name' => 'test 2',
            'role_id' => 2,
        ]);

        Employer::create([
            'name' => 'test 3',
            'role_id' => 2,
        ]);
    }
}
