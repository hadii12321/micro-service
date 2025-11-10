<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MasterUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit' => 'required|string|max:100',
            'singkatan' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'unit' => 'Nama Unit',
            'singkatan' => 'Singkatan',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->messages(),
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            'unit.required' => 'Field :attribute wajib diisi.',
            'unit.string' => 'Field :attribute harus berupa teks.',
            'unit.max' => 'Field :attribute maksimal :max karakter.',
            'singkatan.required' => 'Field :attribute wajib diisi.',
            'singkatan.string' => 'Field :attribute harus berupa teks.',
        ];
    }
}
