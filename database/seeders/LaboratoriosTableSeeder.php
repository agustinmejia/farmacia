<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Laboratorio;

class LaboratoriosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Laboratorio::create([
            'nombre' => 'Sin nombre'
        ]);
    }
}
