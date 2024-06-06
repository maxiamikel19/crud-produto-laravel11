<?php

namespace App\Http\Requests;

use App\Models\Produto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $produtoId = $this->route('produto');

        return [
            'nome' => 'required|min:4|max:100|unique:produtos,nome,id'.($produtoId ? $produtoId->id : null),
            'descricao' => 'required|min:10|max:255',
            'preco' => 'required|numeric',
            'estoque' => 'required|numeric',
            'categoria_id' => 'required'
        ];
    }

    public function messages() : array
    {
    
        return [
            'nome.unique' => 'The name is taken',
            'nome.required' => 'The name is required',
            'nome.min' =>  'The name cannot be less than :min characters',
            'nome.max' =>  'The name cannot be more than :max characters',
            'descricao.required' =>  'The descricao is requires',
            'descricao.min' =>  'The descricao cannot be less than :min characters',
            'descricao.max' =>  'The descricao cannot be less than :max characters',
            'price.required' =>  'The price is require',
            'price.numeric' =>  'The price must to be a valid number',
            'estoque.required' =>  'The estoque is require',
            'estoque.numeric' =>  'The estoque must to be a valid number',
            'categoria_id.required' =>  'The categoria id is requires',
            'categoria_id.numeric' =>  'The categoria id must to be a valid number'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors()
        ], 422));
    }
}
