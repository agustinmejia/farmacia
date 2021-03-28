<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Cliente;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombre_completo' => 'Sin nombre',
            'nit' => '00000'
        ]);
    }
}
