<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Sucursal;

class SucursalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursal::create([
            'nombre' => 'Sucursal principal'
        ]);
    }
}
