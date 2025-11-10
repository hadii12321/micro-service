<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmKeluargaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid_person' => 'required_without:id_sdm|uuid|exists:person,uuid_person',
            'id_sdm' => 'required_without:uuid_person|integer|exists:person_sdm,id_sdm',
            'id_person' => 'required|integer|exists:person,id_person',
            'id_hubungan_keluarga' => 'required|integer|exists:ref_hubungan_keluarga,id_hubungan_keluarga',
            'status_tanggungan' => 'nullable|in:Ya,Tidak',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'penghasilan' => 'nullable|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'uuid_person' => 'UUID Person',
            'id_sdm' => 'ID SDM',
            'id_person' => 'ID Person',
            'id_hubungan_keluarga' => 'Hubungan Keluarga',
            'status_tanggungan' => 'Status Tanggungan',
            'pekerjaan' => 'Pekerjaan',
            'pendidikan_terakhir' => 'Pendidikan Terakhir',
            'penghasilan' => 'Penghasilan',
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
            'uuid_person.required_without' => 'Field :attribute wajib diisi jika id_sdm tidak diisi.',
            'uuid_person.uuid' => 'Field :attribute harus UUID.',
            'uuid_person.exists' => 'Field :attribute tidak ditemukan.',
            'id_sdm.required_without' => 'Field :attribute wajib diisi jika uuid_person tidak diisi.',
            'id_sdm.integer' => 'Field :attribute harus berupa angka.',
            'id_sdm.exists' => 'Field :attribute tidak ditemukan.',
            'id_person.required' => 'Field :attribute wajib diisi.',
            'id_person.integer' => 'Field :attribute harus berupa angka.',
            'id_person.exists' => 'Field :attribute tidak ditemukan.',
            'id_hubungan_keluarga.required' => 'Field :attribute wajib diisi.',
            'id_hubungan_keluarga.integer' => 'Field :attribute harus berupa angka.',
            'id_hubungan_keluarga.exists' => 'Field :attribute tidak ditemukan.',
            'status_tanggungan.in' => 'Field :attribute harus Ya atau Tidak.',
            'pekerjaan.string' => 'Field :attribute harus berupa teks.',
            'pekerjaan.max' => 'Field :attribute maksimal :max karakter.',
            'pendidikan_terakhir.string' => 'Field :attribute harus berupa teks.',
            'pendidikan_terakhir.max' => 'Field :attribute maksimal :max karakter.',
            'penghasilan.numeric' => 'Field :attribute harus berupa angka.',
            'penghasilan.min' => 'Field :attribute minimal :min.',
        ];
    }
}
