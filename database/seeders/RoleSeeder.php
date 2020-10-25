<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Role::upsert([[
            'name'       => 'Member',
            'slug'       => 'member',
        ], [
            'name'       => 'Senior Member',
            'slug'       => 'senior_member',
        ]], ['slug'], ['name']);
    }
}
