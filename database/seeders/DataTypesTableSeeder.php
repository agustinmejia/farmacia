<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'Usuario',
                'display_name_plural' => 'Usuarios',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-02-26 13:50:49',
                'updated_at' => '2021-02-26 13:50:49',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menú',
                'display_name_plural' => 'Menús',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-02-26 13:50:49',
                'updated_at' => '2021-02-26 13:50:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Rol',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-02-26 13:50:49',
                'updated_at' => '2021-02-26 13:50:49',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'lineas',
                'slug' => 'lineas',
                'display_name_singular' => 'Linea',
                'display_name_plural' => 'Lineas',
                'icon' => 'voyager-tag',
                'model_name' => 'App\\Models\\Linea',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":"nombre","order_direction":"asc","default_search_key":"nombre","scope":null}',
                'created_at' => '2021-03-03 00:49:07',
                'updated_at' => '2021-03-03 00:54:07',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'laboratorios',
                'slug' => 'laboratorios',
                'display_name_singular' => 'Laboratorio',
                'display_name_plural' => 'Laboratorios',
                'icon' => 'voyager-lab',
                'model_name' => 'App\\Models\\Laboratorio',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":"nombre","order_direction":"asc","default_search_key":"nombre"}',
                'created_at' => '2021-03-03 00:53:46',
                'updated_at' => '2021-03-03 00:53:46',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'productos',
                'slug' => 'productos',
                'display_name_singular' => 'Producto',
                'display_name_plural' => 'Productos',
                'icon' => 'voyager-bag',
                'model_name' => 'App\\Models\\Producto',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":"nombre","order_direction":"asc","default_search_key":"nombre","scope":null}',
                'created_at' => '2021-03-03 01:17:34',
                'updated_at' => '2021-03-03 01:22:32',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'sucursals',
                'slug' => 'sucursals',
                'display_name_singular' => 'Sucursal',
                'display_name_plural' => 'Sucursales',
                'icon' => 'voyager-shop',
                'model_name' => 'App\\Models\\Sucursal',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":"nombre","order_direction":"asc","default_search_key":"nombre","scope":null}',
                'created_at' => '2021-03-03 01:25:20',
                'updated_at' => '2021-03-03 01:28:57',
            ),
        ));
        
        
    }
}