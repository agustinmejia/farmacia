<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class DatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->seed('VoyagerDatabaseSeeder');
        $this->call([
            UsersTableSeeder::class
        ]);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(DataTypesTableSeeder::class);
        $this->call(DataRowsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(SucursalesTableSeeder::class);
        $this->call(LaboratoriosTableSeeder::class);
        $this->call(LineasTableSeeder::class);
        $this->call(ProveedoresTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
    }
}
