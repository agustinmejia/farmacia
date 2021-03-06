<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_admin',
            'browse_bread',
            'browse_database',
            'browse_media',
            'browse_compass',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::generateFor('menus');
        Permission::generateFor('roles');
        Permission::generateFor('users');
        Permission::generateFor('settings');

        ////////////////////////////////////////
        Permission::generateFor('lineas');
        Permission::generateFor('laboratorios');
        Permission::generateFor('productos');
        Permission::generateFor('sucursals');
        Permission::generateFor('inventario');
        Permission::generateFor('proveedores');
        Permission::generateFor('compras');
        Permission::generateFor('clientes');
        Permission::generateFor('ventas');
        Permission::generateFor('cajas');
        Permission::generateFor('cajadetalles');
    }
}
