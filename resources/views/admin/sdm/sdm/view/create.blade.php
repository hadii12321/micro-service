<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">
                        Tambah SDM
                    </h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-column mb-4">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>NIK</span>
                                </label>
                                <input type="text" id="search_nik" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="16"
                                       placeholder="Masukkan NIK untuk mencari person" required>
                                <div class="invalid-feedback"></div>
                                <div class="mt-3">
                                    <button type="button" id="btn_search_person" class="btn btn-sm btn-info me-2">

                                        Cari Person
                                    </button>
                                    <button type="button" id="btn_clear_person" class="btn btn-sm btn-warning">

                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="person_info" style="display:none;"
                             class="mb-4 p-4 bg-light-success border border-success border-dashed rounded">
                            <h6 class="text-success mb-3 fw-bold">
                                Data Person Ditemukan:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama:</strong> <span id="person_nama"></span></p>
                                    <p class="mb-1"><strong>NIK:</strong> <span id="person_nik"></span></p>
                                    <p class="mb-1"><strong>Tempat Lahir:</strong> <span
                                                id="person_tempat_lahir"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Tanggal Lahir:</strong> <span
                                                id="person_tanggal_lahir"></span></p>
                                    <p class="mb-1"><strong>Alamat:</strong> <span id="person_alamat"></span></p>
                                </div>
                            </div>
                            <input type="hidden" id="id_person" name="id_person">
                        </div>
                        <div class="row" id="sdm_form" style="display:none;">
                            <div class="col-md-4">
                                <div class="d-flex flex-column mb-2">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>Karpeg</span>
                                    </label>
                                    <input type="text" id="nomor_karpeg"
                                           class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="20">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column mb-2">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>Nomor SK</span>
                                    </label>
                                    <input type="text" id="nomor_sk"
                                           class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="50">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column mb-2">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>TMT (Terhitung Mulai Tanggal)</span>
                                    </label>
                                    <input type="text" id="tmt"
                                           class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column mb-2">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>TMT Pensiun (Terhitung Mulai Tanggal)</span>
                                    </label>
                                    <input type="text" id="tmt_pensiun"
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
                        <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" id="btn_save"
                                style="display:none;">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
