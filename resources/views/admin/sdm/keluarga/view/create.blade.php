<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Tambah Anggota Keluarga SDM
                    </h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex flex-column mb-2">
                            <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                <span>NIK</span>
                            </label>
                            <input type="text" id="search_nik" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                   maxlength="16" placeholder="Masukkan NIK untuk mencari person anggota keluarga"
                                   required>
                            <div class="invalid-feedback"></div>
                            <div class="mt-2">
                                <button type="button" id="btn_search_person"
                                        class="btn btn-sm btn-info me-2">
                                    Cari Person
                                </button>
                                <button type="button" id="btn_clear_person"
                                        class="btn btn-sm btn-warning">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="person_info" style="display:none;"
                         class="mb-4 p-3 bg-light-success border border-success border-dashed rounded justify-content-md-center">
                        <h6 class="text-success mb-2">Data Ditemukan:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama:</strong> <span id="person_nama"></span></p>
                                <p class="mb-1"><strong>NIK:</strong> <span id="person_nik"></span></p>
                                <p class="mb-1"><strong>Tempat Lahir:</strong> <span id="person_tempat_lahir"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Lahir:</strong> <span
                                            id="person_tanggal_lahir"></span></p>
                                <p class="mb-1"><strong>Alamat:</strong> <span id="person_alamat"></span></p>
                            </div>
                        </div>
                        <input type="hidden" id="id_person" name="id_person">
                        <input type="hidden" id="id_sdm" name="id_sdm">
                    </div>
                    <div class="row" id="keluarga_form" style="display:none;">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Hubungan Keluarga</span>
                                </label>
                                <select data-control="select2" id="id_hubungan_keluarga"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Hubungan Keluarga" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Status Tanggungan</span>
                                </label>
                                <select data-control="select2" id="status_tanggungan"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status">
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Pekerjaan</span>
                                </label>
                                <input type="text" id="pekerjaan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="100"
                                       placeholder="Masukkan pekerjaan">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Pendidikan Terakhir</span>
                                </label>
                                <input type="text" id="pendidikan_terakhir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="100"
                                       placeholder="Masukkan pendidikan terakhir">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Penghasilan</span>
                                </label>
                                <input type="number" id="penghasilan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" min="0"
                                       placeholder="Masukkan penghasilan">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" id="btn_save"
                            style="display:none;">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>