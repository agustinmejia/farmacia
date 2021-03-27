<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Proveedore;

class ProveedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedore::create([
            'nombre' => 'Sin nombre'
        ]);
    }
}
