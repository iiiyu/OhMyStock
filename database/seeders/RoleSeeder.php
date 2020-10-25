<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Role;
use Illuminate\Support\Facades\DB;

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

        if (Role::where('id', 2)->count() == 0) {
            DB::transaction(function () {
                Role::insert([
                    [
                        'id'         => '2',
                        'name'       => 'Member',
                        'slug'       => 'member',
                    ],
                    [
                        'id'         => '3',
                        'name'       => 'Senior Member',
                        'slug'       => 'senior_member',
                    ]
                ]);
            });
        }
    }
}
