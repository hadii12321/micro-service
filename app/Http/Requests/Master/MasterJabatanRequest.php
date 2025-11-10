<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MasterJabatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jabatan' => 'required|string|max:150',
            'id_unit' => 'required|integer',
            'id_periode' => 'required|integer',
            'id_eselon' => 'required|integer',
        ];
    }

    public function attributes(): array
    {
        return [
            'jabatan' => 'jabatan',
            'id_unit' => 'unit',
            'id_periode' => 'periode',
            'id_eselon' => 'eselon',
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
            'jabatan.required' => 'Field :attribute wajib diisi.',
            'jabatan.string' => 'Field :attribute harus berupa teks.',
            'jabatan.max' => 'Field :attribute maksimal :max karakter.',
            'id_unit.required' => 'Field :attribute wajib dipilih.',
            'id_unit.integer' => 'Field :attribute harus berupa angka yang valid.',
            'id_periode.required' => 'Field :attribute wajib dipilih.',
            'id_periode.integer' => 'Field :attribute harus berupa angka yang valid.',
            'id_eselon.required' => 'Field :attribute wajib dipilih.',
            'id_eselon.integer' => 'Field :attribute harus berupa angka yang valid.',
        ];
    }
}
