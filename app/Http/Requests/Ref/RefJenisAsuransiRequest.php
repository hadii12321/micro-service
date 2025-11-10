<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefJenisAsuransiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_asuransi' => 'required|string|max:100',
            'nama_produk' => 'required|string|max:100',
            'provider' => 'required|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'jenis_asuransi' => 'Jenis Asuransi',
            'nama_produk' => 'Nama Produk',
            'provider' => 'Provider',
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
            'jenis_asuransi.required' => 'Field :attribute wajib diisi.',
            'jenis_asuransi.string' => 'Field :attribute harus berupa teks.',
            'jenis_asuransi.max' => 'Field :attribute maksimal :max karakter.',
            'nama_produk.required' => 'Field :attribute wajib diisi.',
            'nama_produk.string' => 'Field :attribute harus berupa teks.',
            'nama_produk.max' => 'Field :attribute maksimal :max karakter.',
            'provider.required' => 'Field :attribute wajib diisi.',
            'provider.string' => 'Field :attribute harus berupa teks.',
            'provider.max' => 'Field :attribute maksimal :max karakter.',
        ];
    }
}
