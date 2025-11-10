<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Riwayat Pendidikan
                </h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <form method="post" id="bt_submit_edit" novalidate enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="required d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Jenjang
                                    Pendidikan</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm"
                                        id="edit_id_jenjang_pendidikan"
                                        name="id_jenjang_pendidikan"
                                        data-placeholder="Pilih Jenjang Pendidikan"
                                        data-allow-clear="true">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama
                                    Sekolah</label>
                                <input type="text" name="nama_sekolah"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_nama_sekolah" placeholder="Masukkan nama sekolah" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Negara</label>
                                <input type="text" name="negara"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_negara" placeholder="Masukkan negara" maxlength="50">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Status Sekolah</label>
                                <select data-control="select2" name="status_sekolah"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="edit_status_sekolah" data-allow-clear="true"
                                        data-placeholder="Pilih Status Sekolah">
                                    <option value="Negeri">Negeri</option>
                                    <option value="Swasta">Swasta</option>
                                    <option value="Luar Negeri">Luar Negeri</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_jurusan" placeholder="Masukkan jurusan" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Nomor
                                    Induk</label>
                                <input type="text" name="nomor_induk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_nomor_induk" placeholder="Masukkan nomor induk" maxlength="50">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tahun
                                    Masuk</label>
                                <input type="number" name="tahun_masuk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_tahun_masuk" placeholder="Masukkan tahun masuk" min="1900" max="2100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tahun
                                    Lulus</label>
                                <input type="number" name="tahun_lulus"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_tahun_lulus" placeholder="Masukkan tahun lulus" min="1900" max="2100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Gelar
                                    Akademik</label>
                                <input type="text" name="gelar_akademik"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_gelar_akademik" placeholder="Masukkan gelar akademik" maxlength="10">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Bidang
                                    Studi</label>
                                <input type="text" name="bidang_studi"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_bidang_studi" placeholder="Masukkan bidang studi" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">IPK</label>
                                <input type="number" name="ipk" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_ipk" placeholder="Masukkan IPK" min="0" max="4" step="0.01">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tanggal
                                    Lulus</label>
                                <input type="text" name="tanggal_lulus"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_tanggal_lulus" placeholder="Pilih tanggal lulus">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Jumlah
                                    Semester</label>
                                <input type="number" name="jumlah_semester"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_jumlah_semester" placeholder="Masukkan jumlah semester" min="0"
                                       max="20">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Jumlah
                                    SKS</label>
                                <input type="number" name="jumlah_sks"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_jumlah_sks" placeholder="Masukkan jumlah SKS" min="0" max="200">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Nomor
                                    Ijazah</label>
                                <input type="text" name="nomor_ijazah"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_nomor_ijazah" placeholder="Masukkan nomor ijazah" maxlength="50">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Sumber
                                    Biaya</label>
                                <select data-control="select2" name="sumber_biaya"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="edit_sumber_biaya" data-allow-clear="true"
                                        data-placeholder="Pilih Sumber Biaya">
                                    <option value="Pribadi">Pribadi</option>
                                    <option value="Beasiswa">Beasiswa</option>
                                    <option value="Institusi">Institusi</option>
                                    <option value="Pemerintah">Pemerintah</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama
                                    Pembimbing</label>
                                <input type="text" name="nama_pembimbing"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_nama_pembimbing" placeholder="Masukkan nama pembimbing" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Judul Tugas
                                    Akhir</label>
                                <textarea name="judul_tugas_akhir" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          rows="3" maxlength="255"
                                          id="edit_judul_tugas_akhir"
                                          placeholder="Masukkan judul tugas akhir"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Ijazah</label>
                                <input type="file" id="edit_file_ijazah" name="file_ijazah"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Transkip</label>
                                <input type="file" id="edit_file_transkip" name="file_transkip"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6" id="current_file_ijazah_info">
                                <div class="alert alert-info">
                                    <strong>File Saat Ini:</strong> <span id="current_file_ijazah_name"></span>
                                    <a href="#" id="current_file_ijazah_link" target="_blank"
                                    class="btn btn-sm btn-light-primary ms-2">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6"  id="current_file_transkip_info">
                                <div class="alert alert-info">
                                    <strong>File Saat Ini:</strong> <span id="current_file_transkip_name"></span>
                                    <a href="#" id="current_file_transkip_link" target="_blank"
                                    class="btn btn-sm btn-light-primary ms-2">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>