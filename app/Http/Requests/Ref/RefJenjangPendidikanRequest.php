<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefJenjangPendidikanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenjang_pendidikan' => 'required|string|max:20',
        ];
    }

    public function attributes(): array
    {
        return [
            'jenjang_pendidikan' => 'Jenjang Pendidikan',
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
            'jenjang_pendidikan.required' => 'Field :attribute wajib diisi.',
            'jenjang_pendidikan.string' => 'Field :attribute harus berupa teks.',
            'jenjang_pendidikan.max' => 'Field :attribute maksimal :max karakter.',
        ];
    }
}
