<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use Exception;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function index() : JsonResponse
    {
        $produtos = Produto::select([
            'produtos.nome as nome',
            'produtos.descricao as descricao',
            'produtos.preco as preco',
            'produtos.estoque as estoque',
            'categorias.nome as categoria'
        ])->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
          ->orderBy('produtos.id', 'DESC')
          ->paginate(4);
        return response()->json([
            'status' => true,
            'produtos' => $produtos,
            'message' => 'OK'
        ], 200);
    }

    public function show(Produto $produto) : JsonResponse
    {
        return response()->json([
            'status' => true,
            'produto' => $produto,
            'message' => 'OK'
        ], 200);
    }

    public function store(ProdutoRequest $request) : JsonResponse
    {
        DB::beginTransaction();
        
        try {

            $produto = Produto::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'estoque' => $request->estoque,
                'categoria_id' => $request->categoria_id
            ]);

            DB::commit();
            
            return response()->json([
            'status' => true,
            'produto' => $produto,
            'message' => 'OK'
        ], 201);
        } catch (Exception $e) {
            
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Error creating the product:'.$e->getMessage()
            ], 400);
        }
    }

    public function update(ProdutoRequest $request, Produto $produto) : JsonResponse
    {
        DB::beginTransaction();

        try {
            $produto->update([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'estoque' => $request->estoque
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'produto' => $produto,
                'message' => 'Successfully updated'
            ]);

        } catch (Exception $e) {
            
            return response()->json([
                'status' => false,
                'message' => 'Failed updatting the product'
            ],400);
        }
    }

    public function destroy(Produto $produto) : JsonResponse
    {
        DB::beginTransaction();

        try {
            $produto->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Successfully deleted'
            ]);

        } catch (Exception $e) {
            
            return response()->json([
                'status' => false,
                'message' => 'Failed deleting the product'
            ],400);
        }
    }

}
