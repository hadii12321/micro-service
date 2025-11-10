<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmStrukturalStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid_person' => 'required|uuid|exists:person,uuid_person',
            'id_unit' => 'required|integer|exists:master_unit,id_unit',
            'id_jabatan' => 'required|integer|exists:master_jabatan,id_jabatan',
            'nomor_sk' => 'required|string|max:50',
            'tanggal_sk' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'masa_jabatan' => 'nullable|numeric|min:0|max:80',
            'tanggal_keluar' => 'nullable|date',
            'sk_pemberhentian' => 'nullable|string|max:50',
            'alasan_keluar' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'file_sk_masuk' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'file_sk_keluar' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ];
    }

    public function attributes(): array
    {
        return [
            'uuid_person' => 'UUID Person',
            'id_unit' => 'Unit',
            'id_jabatan' => 'Jabatan',
            'nomor_sk' => 'Nomor SK',
            'tanggal_sk' => 'Tanggal SK',
            'tanggal_masuk' => 'Tanggal Masuk',
            'masa_jabatan' => 'Masa Jabatan',
            'tanggal_keluar' => 'Tanggal Keluar',
            'sk_pemberhentian' => 'SK Pemberhentian',
            'alasan_keluar' => 'Alasan Keluar',
            'keterangan' => 'Keterangan',
            'file_sk_masuk' => 'File SK Masuk',
            'file_sk_keluar' => 'File SK Keluar',
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
            'uuid_person.required' => 'UUID person wajib diisi.',
            'uuid_person.uuid' => 'UUID person tidak valid.',
            'uuid_person.exists' => 'UUID person tidak ditemukan.',
            'id_unit.required' => 'Unit wajib diisi.',
            'id_unit.integer' => 'Unit harus berupa angka.',
            'id_unit.exists' => 'Unit tidak ditemukan.',
            'id_jabatan.required' => 'Jabatan wajib diisi.',
            'id_jabatan.integer' => 'Jabatan harus berupa angka.',
            'id_jabatan.exists' => 'Jabatan tidak ditemukan.',
            'nomor_sk.required' => 'Nomor SK wajib diisi.',
            'nomor_sk.string' => 'Nomor SK harus berupa teks.',
            'nomor_sk.max' => 'Nomor SK maksimal 50 karakter.',
            'tanggal_sk.required' => 'Tanggal SK wajib diisi.',
            'tanggal_sk.date' => 'Tanggal SK harus berupa tanggal.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Tanggal masuk harus berupa tanggal.',
            'masa_jabatan.numeric' => 'Masa jabatan harus berupa angka.',
            'masa_jabatan.min' => 'Masa jabatan minimal 0.',
            'masa_jabatan.max' => 'Masa jabatan maksimal 80.',
            'tanggal_keluar.date' => 'Tanggal keluar harus berupa tanggal.',
            'sk_pemberhentian.string' => 'SK pemberhentian harus berupa teks.',
            'sk_pemberhentian.max' => 'SK pemberhentian maksimal 50 karakter.',
            'alasan_keluar.string' => 'Alasan keluar harus berupa teks.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'file_sk_masuk.file' => 'File SK masuk harus berupa file.',
            'file_sk_masuk.max' => 'File SK masuk maksimal 10MB.',
            'file_sk_masuk.mimes' => 'File SK masuk harus bertipe pdf, jpg, jpeg, atau png.',
            'file_sk_keluar.file' => 'File SK keluar harus berupa file.',
            'file_sk_keluar.max' => 'File SK keluar maksimal 10MB.',
            'file_sk_keluar.mimes' => 'File SK keluar harus bertipe pdf, jpg, jpeg, atau png.',
        ];
    }
}
