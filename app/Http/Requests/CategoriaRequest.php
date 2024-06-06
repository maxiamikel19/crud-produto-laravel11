<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoriaRequest extends FormRequest
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
        $categoriaId = $this->route('categoria');
        return [
            'nome' => 'required|max:100|min:4|unique:categorias,nome,'.($categoriaId ? $categoriaId->id : null)
        ];
    }

    public function messages():array
    {
        return [
            'nome.required' => 'The category name is required',
            'nome.max' => 'The category name is too long than :max',
            'nome.min' => 'The category name must have more tham :min characters',
            'nome.unique' => 'The category name is taken'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' =>$validator->errors()
        ], 422));
    }
}
