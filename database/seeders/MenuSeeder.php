<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Menu::where('id', 8)->count() == 0) {

            DB::transaction(function () {
                $createdAt = date('Y-m-d H:i:s');
                Menu::insert([
                    [
                        'id'            => 8,
                        'parent_id'     => 0,
                        'order'         => 8,
                        'title'         => 'Active Stocks',
                        'icon'          => 'fa-angellist',
                        'uri'           => '/active-stocks',
                        'created_at'    => $createdAt,
                    ],
                    [
                        'id'            => 9,
                        'parent_id'     => 0,
                        'order'         => 9,
                        'title'         => 'Premium',
                        'icon'          => '',
                        'uri'           => '',
                        'created_at'    => $createdAt,
                    ],                [
                        'id'            => 10,
                        'parent_id'     => 9,
                        'order'         => 10,
                        'title'         => 'Companies',
                        'icon'          => 'fa-bank',
                        'uri'           => '/companies',
                        'created_at'    => $createdAt,
                    ],
                    [
                        'id'            => 11,
                        'parent_id'     => 9,
                        'order'         => 11,
                        'title'         => 'Series',
                        'icon'          => 'fa-american-sign-language-interpreting',
                        'uri'           => '/series',
                        'created_at'    => $createdAt,
                    ],
                ]);


                DB::table('admin_permission_menu')->insert([
                    ['permission_id' => 8, 'menu_id' => 10],
                    ['permission_id' => 9, 'menu_id' => 11],
                    ['permission_id' => 10, 'menu_id' => 8]
                ]);

                DB::table('admin_role_menu')->insert([
                    ['role_id' => 1, 'menu_id' => 2],
                    ['role_id' => 1, 'menu_id' => 9],
                    ['role_id' => 1, 'menu_id' => 10],
                    ['role_id' => 1, 'menu_id' => 11],
                    ['role_id' => 2, 'menu_id' => 8],
                    ['role_id' => 3, 'menu_id' => 8],
                    ['role_id' => 3, 'menu_id' => 9],
                    ['role_id' => 3, 'menu_id' => 10],
                    ['role_id' => 3, 'menu_id' => 11]
                ]);

                DB::table('admin_role_permissions')->insert([
                    ['role_id' => 2, 'permission_id' => 10],
                    ['role_id' => 3, 'permission_id' => 8],
                    ['role_id' => 3, 'permission_id' => 9],
                    ['role_id' => 3, 'permission_id' => 10],
                ]);
            });
        }
    }
}
