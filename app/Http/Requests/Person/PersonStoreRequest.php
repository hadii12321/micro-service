<?php

namespace App\Http\Requests\Person;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:50',
            'jk' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'kewarganegaraan' => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,O,AB',
            'nik' => 'nullable|string|max:16|unique:person,nik',
            'nomor_kk' => 'nullable|string|max:16',
            'alamat' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'id_desa' => 'nullable|integer|exists:ref_almt_desa,id_desa',
            'npwp' => 'nullable|string|max:30',
            'nomor_hp' => 'nullable|string|max:16',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|max:2048|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'jk' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'kewarganegaraan' => 'Kewarganegaraan',
            'golongan_darah' => 'Golongan Darah',
            'nik' => 'NIK',
            'nomor_kk' => 'Nomor KK',
            'alamat' => 'Alamat',
            'rt' => 'RT',
            'rw' => 'RW',
            'id_desa' => 'Desa',
            'npwp' => 'NPWP',
            'nomor_hp' => 'Nomor HP',
            'email' => 'Email',
            'foto' => 'Foto',
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
            'nama.required' => 'Field :attribute wajib diisi.',
            'nama.string' => 'Field :attribute harus berupa teks.',
            'nama.max' => 'Field :attribute maksimal :max karakter.',
            'jk.required' => 'Field :attribute wajib diisi.',
            'jk.in' => 'Field :attribute harus L atau P.',
            'tempat_lahir.required' => 'Field :attribute wajib diisi.',
            'tempat_lahir.string' => 'Field :attribute harus berupa teks.',
            'tempat_lahir.max' => 'Field :attribute maksimal :max karakter.',
            'tanggal_lahir.required' => 'Field :attribute wajib diisi.',
            'tanggal_lahir.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'kewarganegaraan.string' => 'Field :attribute harus berupa teks.',
            'golongan_darah.in' => 'Field :attribute harus salah satu dari: A, B, O, AB.',
            'nik.string' => 'Field :attribute harus berupa teks.',
            'nik.max' => 'Field :attribute maksimal :max karakter.',
            'nik.unique' => 'Field :attribute sudah digunakan.',
            'nomor_kk.string' => 'Field :attribute harus berupa teks.',
            'nomor_kk.max' => 'Field :attribute maksimal :max karakter.',
            'alamat.string' => 'Field :attribute harus berupa teks.',
            'alamat.max' => 'Field :attribute maksimal :max karakter.',
            'rt.string' => 'Field :attribute harus berupa teks.',
            'rt.max' => 'Field :attribute maksimal :max karakter.',
            'rw.string' => 'Field :attribute harus berupa teks.',
            'rw.max' => 'Field :attribute maksimal :max karakter.',
            'id_desa.integer' => 'Field :attribute harus berupa angka.',
            'id_desa.exists' => 'Field :attribute tidak ditemukan.',
            'npwp.string' => 'Field :attribute harus berupa teks.',
            'npwp.max' => 'Field :attribute maksimal :max karakter.',
            'nomor_hp.string' => 'Field :attribute harus berupa teks.',
            'nomor_hp.max' => 'Field :attribute maksimal :max karakter.',
            'email.email' => 'Field :attribute harus berupa email yang valid.',
            'email.max' => 'Field :attribute maksimal :max karakter.',
            'foto.image' => 'Field :attribute harus berupa gambar.',
            'foto.max' => 'Field :attribute maksimal :max KB.',
            'foto.mimes' => 'Field :attribute harus bertipe: jpg, jpeg, png.',
            'foto.mimetypes' => 'Field :attribute harus bertipe: image/jpeg, image/png.',
        ];
    }
}
