<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit Anggota Keluarga
                    </h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama Anggota</label>
                                <p id="edit_nama_anggota"
                                   class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">NIK Anggota</label>
                                <p id="edit_nik_anggota"
                                   class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Hubungan Keluarga</span>
                                </label>
                                <select data-control="select2" id="edit_id_hubungan_keluarga"
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
                                <select data-control="select2" id="edit_status_tanggungan"
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
                                <input type="text" id="edit_pekerjaan"
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
                                <input type="text" id="edit_pendidikan_terakhir"
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
                                <input type="number" id="edit_penghasilan"
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
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>