<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmRiwayatPendidikanStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid_person' => 'required|uuid|exists:person,uuid_person',
            'id_jenjang_pendidikan' => 'nullable|integer|exists:ref_jenjang_pendidikan,id_jenjang_pendidikan',
            'nama_sekolah' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:50',
            'status_sekolah' => 'nullable|in:Negeri,Swasta,Luar Negeri',
            'jurusan' => 'nullable|string|max:100',
            'nomor_induk' => 'nullable|string|max:50',
            'tahun_masuk' => 'nullable|numeric|digits:4|min:1900|max:2099',
            'tahun_lulus' => 'nullable|numeric|digits:4|min:1900|max:2099',
            'gelar_akademik' => 'nullable|string|max:10',
            'bidang_studi' => 'nullable|string|max:100',
            'ipk' => 'nullable|numeric|min:0|max:4.00',
            'tanggal_lulus' => 'nullable|date',
            'jumlah_semester' => 'nullable|numeric|min:0|max:255',
            'jumlah_sks' => 'nullable|numeric|min:0|max:255',
            'nomor_ijazah' => 'nullable|string|max:50',
            'judul_tugas_akhir' => 'nullable|string|max:255',
            'sumber_biaya' => 'nullable|in:Pribadi,Beasiswa,Institusi,Pemerintah',
            'nama_pembimbing' => 'nullable|string|max:100',
            'file_ijazah' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'file_transkip' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ];
    }

    public function attributes(): array
    {
        return [
            'uuid_person' => 'UUID Person',
            'id_jenjang_pendidikan' => 'Jenjang Pendidikan',
            'nama_sekolah' => 'Nama Sekolah',
            'negara' => 'Negara',
            'status_sekolah' => 'Status Sekolah',
            'jurusan' => 'Jurusan',
            'nomor_induk' => 'Nomor Induk',
            'tahun_masuk' => 'Tahun Masuk',
            'tahun_lulus' => 'Tahun Lulus',
            'gelar_akademik' => 'Gelar Akademik',
            'bidang_studi' => 'Bidang Studi',
            'ipk' => 'IPK',
            'tanggal_lulus' => 'Tanggal Lulus',
            'jumlah_semester' => 'Jumlah Semester',
            'jumlah_sks' => 'Jumlah SKS',
            'nomor_ijazah' => 'Nomor Ijazah',
            'judul_tugas_akhir' => 'Judul Tugas Akhir',
            'sumber_biaya' => 'Sumber Biaya',
            'nama_pembimbing' => 'Nama Pembimbing',
            'file_ijazah' => 'File Ijazah',
            'file_transkip' => 'File Transkip',
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
            'id_jenjang_pendidikan.integer' => 'Jenjang pendidikan harus berupa angka.',
            'id_jenjang_pendidikan.exists' => 'Jenjang pendidikan tidak ditemukan.',
            'nama_sekolah.string' => 'Nama sekolah harus berupa teks.',
            'nama_sekolah.max' => 'Nama sekolah maksimal 100 karakter.',
            'negara.string' => 'Negara harus berupa teks.',
            'negara.max' => 'Negara maksimal 50 karakter.',
            'status_sekolah.in' => 'Status sekolah harus Negeri, Swasta, atau Luar Negeri.',
            'jurusan.string' => 'Jurusan harus berupa teks.',
            'jurusan.max' => 'Jurusan maksimal 100 karakter.',
            'nomor_induk.string' => 'Nomor induk harus berupa teks.',
            'nomor_induk.max' => 'Nomor induk maksimal 50 karakter.',
            'tahun_masuk.numeric' => 'Tahun masuk harus berupa angka.',
            'tahun_masuk.digits' => 'Tahun masuk harus 4 digit.',
            'tahun_masuk.min' => 'Tahun masuk minimal 1900.',
            'tahun_masuk.max' => 'Tahun masuk maksimal 2099.',
            'tahun_lulus.numeric' => 'Tahun lulus harus berupa angka.',
            'tahun_lulus.digits' => 'Tahun lulus harus 4 digit.',
            'tahun_lulus.min' => 'Tahun lulus minimal 1900.',
            'tahun_lulus.max' => 'Tahun lulus maksimal 2099.',
            'gelar_akademik.string' => 'Gelar akademik harus berupa teks.',
            'gelar_akademik.max' => 'Gelar akademik maksimal 10 karakter.',
            'bidang_studi.string' => 'Bidang studi harus berupa teks.',
            'bidang_studi.max' => 'Bidang studi maksimal 100 karakter.',
            'ipk.numeric' => 'IPK harus berupa angka.',
            'ipk.min' => 'IPK minimal 0.',
            'ipk.max' => 'IPK maksimal 4.00.',
            'tanggal_lulus.date' => 'Tanggal lulus harus berupa tanggal.',
            'jumlah_semester.numeric' => 'Jumlah semester harus berupa angka.',
            'jumlah_semester.min' => 'Jumlah semester minimal 0.',
            'jumlah_semester.max' => 'Jumlah semester maksimal 255.',
            'jumlah_sks.numeric' => 'Jumlah SKS harus berupa angka.',
            'jumlah_sks.min' => 'Jumlah SKS minimal 0.',
            'jumlah_sks.max' => 'Jumlah SKS maksimal 255.',
            'nomor_ijazah.string' => 'Nomor ijazah harus berupa teks.',
            'nomor_ijazah.max' => 'Nomor ijazah maksimal 50 karakter.',
            'judul_tugas_akhir.string' => 'Judul tugas akhir harus berupa teks.',
            'judul_tugas_akhir.max' => 'Judul tugas akhir maksimal 255 karakter.',
            'sumber_biaya.in' => 'Sumber biaya harus Pribadi, Beasiswa, Institusi, atau Pemerintah.',
            'nama_pembimbing.string' => 'Nama pembimbing harus berupa teks.',
            'nama_pembimbing.max' => 'Nama pembimbing maksimal 100 karakter.',
            'file_ijazah.file' => 'File ijazah harus berupa file.',
            'file_ijazah.max' => 'File ijazah maksimal 10MB.',
            'file_ijazah.mimes' => 'File ijazah harus bertipe pdf, jpg, jpeg, atau png.',
            'file_transkip.file' => 'File transkip harus berupa file.',
            'file_transkip.max' => 'File transkip maksimal 10MB.',
            'file_transkip.mimes' => 'File transkip harus bertipe pdf, jpg, jpeg, atau png.',
        ];
    }
}
