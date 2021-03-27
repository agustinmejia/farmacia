<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Linea;

class LineasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Linea::create([
            'nombre' => 'Sin nombre'
        ]);
    }
}
