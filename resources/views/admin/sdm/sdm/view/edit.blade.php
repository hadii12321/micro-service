<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">
                        Edit SDM
                    </h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama</label>
                                <p id="edit_nama"
                                   class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">NIK</label>
                                <p id="edit_nik"
                                   class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Nomor HP</label>
                                <p id="edit_nomor_hp"
                                   class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>KARPEG</span>
                                </label>
                                <input type="text" id="edit_nomor_karpeg"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="20">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nomor SK</span>
                                </label>
                                <input type="text" id="edit_nomor_sk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="50">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>TMT (Terhitung Mulai Tanggal)</span>
                                </label>
                                <input type="text" id="edit_tmt"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>TMT Pensiun (Terhitung Mulai Tanggal)</span>
                                </label>
                                <input type="text" id="edit_tmt_pensiun"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
