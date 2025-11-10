<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefHubunganKeluargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hubungan_keluarga' => 'required|string|max:50',
            'jk' => 'required|string|max:1|in:L,P',
        ];
    }

    public function attributes(): array
    {
        return [
            'hubungan_keluarga' => 'Hubungan Keluarga',
            'jk' => 'Jenis Kelamin',
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
            'hubungan_keluarga.required' => 'Field :attribute wajib diisi.',
            'hubungan_keluarga.string' => 'Field :attribute harus berupa teks.',
            'hubungan_keluarga.max' => 'Field :attribute maksimal :max karakter.',
            'jk.required' => 'Field :attribute wajib diisi.',
            'jk.string' => 'Field :attribute harus berupa teks.',
            'jk.max' => 'Field :attribute maksimal :max karakter.',
            'jk.in' => 'Field :attribute harus L atau P.',
        ];
    }
}
