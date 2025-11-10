<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmRekeningStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid_person' => 'required|uuid|exists:person,uuid_person',
            'no_rekening' => 'required|string|max:25',
            'bank' => 'required|string|max:50',
            'nama_pemilik' => 'nullable|string|max:100',
            'kode_bank' => 'nullable|string|max:10',
            'cabang_bank' => 'nullable|string|max:100',
            'rekening_utama' => 'nullable|in:y,n',
            'jenis_rekening' => 'nullable|in:Tabungan,Giro,Deposito',
            'status_aktif' => 'nullable|in:Aktif,Nonaktif,Ditutup',
        ];
    }

    public function attributes(): array
    {
        return [
            'uuid_person' => 'UUID Person',
            'no_rekening' => 'Nomor Rekening',
            'bank' => 'Bank',
            'nama_pemilik' => 'Nama Pemilik',
            'kode_bank' => 'Kode Bank',
            'cabang_bank' => 'Cabang Bank',
            'rekening_utama' => 'Rekening Utama',
            'jenis_rekening' => 'Jenis Rekening',
            'status_aktif' => 'Status Aktif',
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
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.string' => 'Nomor rekening harus berupa teks.',
            'no_rekening.max' => 'Nomor rekening maksimal 25 karakter.',
            'bank.required' => 'Nama bank wajib diisi.',
            'bank.string' => 'Nama bank harus berupa teks.',
            'bank.max' => 'Nama bank maksimal 50 karakter.',
            'nama_pemilik.string' => 'Nama pemilik harus berupa teks.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 100 karakter.',
            'kode_bank.string' => 'Kode bank harus berupa teks.',
            'kode_bank.max' => 'Kode bank maksimal 10 karakter.',
            'cabang_bank.string' => 'Cabang bank harus berupa teks.',
            'cabang_bank.max' => 'Cabang bank maksimal 100 karakter.',
            'rekening_utama.in' => 'Rekening utama harus y atau n.',
            'jenis_rekening.in' => 'Jenis rekening harus Tabungan, Giro, atau Deposito.',
            'status_aktif.in' => 'Status aktif harus Aktif, Nonaktif, atau Ditutup.',
        ];
    }
}
