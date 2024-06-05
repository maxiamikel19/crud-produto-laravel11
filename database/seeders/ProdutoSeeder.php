<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produto::create([
            'nome' => 'Jeans Silver',
            'descricao' => 'Produto da melhor qualidade',
            'preco' => 150.00,
            'estoque' => 200,
            'categoria_id' => 2
        ]);
    }
}
