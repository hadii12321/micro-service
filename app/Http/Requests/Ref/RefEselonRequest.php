<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefEselonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'eselon' => 'required|string|max:50',
        ];
    }

    public function attributes(): array
    {
        return [
            'eselon' => 'Eselon',
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
            'eselon.required' => 'Field :attribute wajib diisi.',
            'eselon.string' => 'Field :attribute harus berupa teks.',
            'eselon.max' => 'Field :attribute maksimal :max karakter.',
        ];
    }
}
