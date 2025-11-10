<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">

                    Edit Rekening
                </h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <form id="bt_submit_edit" novalidate>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="required d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">No
                                    Rekening</label>
                                <input type="text" name="no_rekening"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_no_rekening" placeholder="Masukkan nomor rekening" maxlength="25"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="required d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Bank</label>
                                <input type="text" name="bank"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_bank" placeholder="Masukkan nama bank" maxlength="50" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama Pemilik</label>
                                <input type="text" name="nama_pemilik"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_nama_pemilik" placeholder="Masukkan nama pemilik" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Kode Bank</label>
                                <input type="text" name="kode_bank"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_kode_bank" placeholder="Masukkan kode bank" maxlength="10">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Cabang Bank</label>
                                <input type="text" name="cabang_bank"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="edit_cabang_bank" placeholder="Masukkan cabang bank" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Jenis Rekening</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="edit_jenis_rekening"
                                        name="jenis_rekening"
                                        data-placeholder="Pilih Jenis Rekening">
                                    <option></option>
                                    <option value="Tabungan">Tabungan</option>
                                    <option value="Giro">Giro</option>
                                    <option value="Deposito">Deposito</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Status Aktif</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="edit_status_aktif"
                                        name="status_aktif"
                                        data-placeholder="Pilih Status Aktif">
                                    <option></option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                    <option value="Ditutup">Ditutup</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Rekening Utama</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="edit_rekening_utama"
                                        name="rekening_utama"
                                        data-placeholder="Pilih Rekening Utama">
                                    <option></option>
                                    <option value="y">Ya</option>
                                    <option value="n">Tidak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">
                        <span class="indicator-label">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>