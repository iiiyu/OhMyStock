<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Permission::where('slug', 'premium')->count() > 0) {
            return 0;
        }

        $createdAt = date('Y-m-d H:i:s');
        Permission::insert([
            [
                'id'          => 7,
                'name'        => 'Premium',
                'slug'        => 'premium',
                'http_method' => '',
                'http_path'   => '',
                'parent_id'   => 0,
                'order'       => 7,
                'created_at' => $createdAt,
            ],
            [
                'id'          => 8,
                'name'        => 'Companies',
                'slug'        => 'companies',
                'http_method' => '',
                'http_path'   => '/companies*',
                'parent_id'   => 7,
                'order'       => 8,
                'created_at' => $createdAt,
            ],
            [
                'id'          => 9,
                'name'        => 'Series',
                'slug'        => 'series',
                'http_method' => 'GET',
                'http_path'   => '/series*',
                'parent_id'   => 7,
                'order'       => 9,
                'created_at' => $createdAt,
            ],
            [
                'id'          => 10,
                'name'        => 'Active Stock',
                'slug'        => 'active-stock',
                'http_method' => 'GET',
                'http_path'   => '/active-stocks*',
                'parent_id'   => 0,
                'order'       => 10,
                'created_at' => $createdAt,
            ],
        ]);
    }
}
