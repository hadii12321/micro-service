<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmRekeningUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_rekening' => 'sometimes|string|max:25',
            'bank' => 'sometimes|string|max:50',
            'nama_pemilik' => 'sometimes|string|max:100|nullable',
            'kode_bank' => 'sometimes|string|max:10|nullable',
            'cabang_bank' => 'sometimes|string|max:100|nullable',
            'rekening_utama' => 'sometimes|in:y,n|nullable',
            'jenis_rekening' => 'sometimes|in:Tabungan,Giro,Deposito|nullable',
            'status_aktif' => 'sometimes|in:Aktif,Nonaktif,Ditutup|nullable',
        ];
    }

    public function attributes(): array
    {
        return [
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
            'no_rekening.string' => 'Nomor rekening harus berupa teks.',
            'no_rekening.max' => 'Nomor rekening maksimal 25 karakter.',
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
