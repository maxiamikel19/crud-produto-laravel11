<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nome' => 'Calças'
        ]);

        Categoria::create([
            'nome' => 'Perfumes'
        ]);

        Categoria::create([
            'nome' => 'Zapatos'
        ]);

        Categoria::create([
            'nome' => 'Camisetas'
        ]);
    }
}
