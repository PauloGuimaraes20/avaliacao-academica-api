<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUnidadeCurricularRequest extends FormRequest
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
            'nome_uc' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'ects' => ['required', 'integer', 'digits_between:1,3']
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
