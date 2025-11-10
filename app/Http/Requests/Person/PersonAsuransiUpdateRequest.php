<?php

namespace App\Http\Requests\Person;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonAsuransiUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_jenis_asuransi' => 'sometimes|integer|exists:ref_jenis_asuransi,id_jenis_asuransi',
            'nomor_registrasi' => 'nullable|string|max:16',
            'kartu_anggota' => 'nullable|string|max:16',
            'status_aktif' => 'nullable|in:Aktif,Nonaktif,Berakhir',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_jenis_asuransi' => 'Jenis Asuransi',
            'nomor_registrasi' => 'Nomor Registrasi',
            'kartu_anggota' => 'Kartu Anggota',
            'status_aktif' => 'Status Aktif',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_berakhir' => 'Tanggal Berakhir',
            'keterangan' => 'Keterangan',
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
            'id_jenis_asuransi.integer' => 'Field :attribute harus berupa angka.',
            'id_jenis_asuransi.exists' => 'Field :attribute tidak ditemukan.',
            'nomor_registrasi.string' => 'Field :attribute harus berupa teks.',
            'nomor_registrasi.max' => 'Field :attribute maksimal :max karakter.',
            'kartu_anggota.string' => 'Field :attribute harus berupa teks.',
            'kartu_anggota.max' => 'Field :attribute maksimal :max karakter.',
            'status_aktif.in' => 'Field :attribute harus salah satu dari: Aktif, Nonaktif, Berakhir.',
            'tanggal_mulai.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'tanggal_berakhir.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'keterangan.string' => 'Field :attribute harus berupa teks.',
        ];
    }
}
