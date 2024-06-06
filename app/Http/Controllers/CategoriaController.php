<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categorias = Categoria::orderBy('id', 'DESC')->paginate(2);
        return response()->json($categorias, 200);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        return response()->json([
            'categoria' => $categoria,
            'produtos' => $categoria->produtos
        ]);
    }

    public function store(CategoriaRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $categoria = Categoria::create([
                'nome' => $request->nome
            ]);

            DB::commit();

            return response()->json([
                'categoria' => $categoria,
                'message' => 'Successfully created!'
            ], 201);
        } catch (Exception $e) {

            DB::rollback();
            
            return response()->json([
                'message' => 'Error creating the new category'
            ], 400);
        }
    }

    public function update(CategoriaRequest $request, Categoria $categoria): JsonResponse
    {
        DB::beginTransaction();

        try {

             $categoria->update([
                'nome' => $request->nome
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'categoria' => $categoria,
                'message' => 'Updated sucessfully'
            ]);
        } catch (\Throwable $th) {

            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Error updating the category'
            ]);
        }
    }

    public function destroy(Categoria $categoria) : JsonResponse
    {
        DB::beginTransaction();

        try {
            
            $categoria->delete($categoria);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Deleted sucessfully'
            ]);
        } catch (Exception $e) {
            
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Error delettion the category'
            ], 401);
        }
    }
}
