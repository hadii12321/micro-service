<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MasterPeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periode' => 'required|string|max:100',
            'tanggal_awal' => 'required|date_format:Y-m-d',
            'tanggal_akhir' => 'required|date_format:Y-m-d|after_or_equal:tanggal_awal',
        ];
    }

    public function attributes(): array
    {
        return [
            'periode' => 'periode',
            'tanggal_awal' => 'tanggal awal',
            'tanggal_akhir' => 'tanggal akhir',
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
            'periode.required' => 'Field :attribute wajib diisi.',
            'periode.string' => 'Field :attribute harus berupa teks.',
            'periode.max' => 'Field :attribute maksimal :max karakter.',
            'tanggal_awal.required' => 'Field :attribute wajib diisi.',
            'tanggal_awal.date_format' => 'Format :attribute harus Y-m-d (contoh: 2025-10-02).',
            'tanggal_akhir.required' => 'Field :attribute wajib diisi.',
            'tanggal_akhir.date_format' => 'Format :attribute harus Y-m-d (contoh: 2025-10-10).',
            'tanggal_akhir.after_or_equal' => 'Field :attribute harus setelah atau sama dengan tanggal awal.',
        ];
    }
}
