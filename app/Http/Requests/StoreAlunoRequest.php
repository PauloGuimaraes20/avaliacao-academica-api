<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreAlunoRequest extends FormRequest
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
            'nif' => ['required', 'integer', 'digits_between:9,9', 'unique:alunos,nif'],
            'nome' => ['required', 'min:2', 'max:255'],
            'data_nascimento' => ['required', 'date', 'date_format:d-m-Y'],
            'email' => ['required', 'email', 'max:255', 'unique:alunos,email'],
            'cod_aluno' => ['required', 'min:9', 'max:9'],
            'curso_id' => ['required','integer', 'exists:cursos,codigo']
        ];
    }

    public function messages()
    {

        return [
            'email.email' => 'O formato do email é inválido',
            'email.unique' => 'O email inserido já existe',
            'nif.digits_between' => 'O NIF deve ter 9 digitos',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(

            response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ]),
            400
        );
    }

}
