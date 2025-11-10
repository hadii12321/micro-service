<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonSdmStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_person' => 'required|integer|exists:person,id_person',
            'nomor_karpeg' => 'nullable|string|max:20',
            'nomor_sk' => 'nullable|string|max:50',
            'tmt' => 'nullable|date',
            'tmt_pensiun' => 'nullable|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_person' => 'ID Person',
            'nomor_karpeg' => 'Nomor Karpeg',
            'nomor_sk' => 'Nomor SK',
            'tmt' => 'TMT',
            'tmt_pensiun' => 'TMT Pensiun',
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
            'id_person.required' => 'Field :attribute wajib diisi.',
            'id_person.integer' => 'Field :attribute harus berupa angka.',
            'id_person.exists' => 'Field :attribute tidak ditemukan.',
            'nomor_karpeg.string' => 'Field :attribute harus berupa teks.',
            'nomor_karpeg.max' => 'Field :attribute maksimal :max karakter.',
            'nomor_sk.string' => 'Field :attribute harus berupa teks.',
            'nomor_sk.max' => 'Field :attribute maksimal :max karakter.',
            'tmt.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'tmt_pensiun.date' => 'Field :attribute harus berupa tanggal yang valid.',
        ];
    }
}
