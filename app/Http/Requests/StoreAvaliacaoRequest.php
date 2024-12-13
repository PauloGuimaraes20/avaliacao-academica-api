<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreAvaliacaoRequest extends FormRequest
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
        return [
            'data_avaliacao' => ['required', 'date', 'date_format:d-m-Y'],
            'comentario' => ['nullable', 'string'],
            'nota' => ['required', 'integer', 'between:0,10'],
            'aluno_id' => ['required', 'exists:alunos,id'],
            'professor_id' => ['nullable', 'exists:professores,id'],
            'curso_id' => ['nullable', 'exists:cursos,id'],
            'uc_id' => ['nullable', 'exists:unidades_curriculares,id'],
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(

            response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ], 400)
        );
    }


}
