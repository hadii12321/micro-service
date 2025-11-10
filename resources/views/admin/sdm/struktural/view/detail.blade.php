<!-- Modal Detail -->
<div class="modal fade" id="form_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">

                    Detail Struktural
                </h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Unit</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_nama_unit"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Jabatan</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_nama_jabatan"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Nomor SK</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_nomor_sk"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tanggal SK</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_tanggal_sk"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tanggal Masuk</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_tanggal_masuk"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Eselon</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_eselon"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Masa Jabatan</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_masa_jabatan"></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="text-muted modal-title">Data Keluar</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tanggal
                                Keluar</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_tanggal_keluar"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">SK
                                Pemberhentian</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_sk_pemberhentian"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Alasan
                                Keluar</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_alasan_keluar"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column mb-2">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Keterangan</label>
                            <p class="fw-light fs-sm-8 fs-lg-6"
                               id="detail_keterangan"></p>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File SK Keluar</label>
                            <div id="detail_file_sk_masuk_section">
                                <div class="d-flex align-items-center mb-3">
                                    <a href="#" id="detail_file_sk_masuk_link" target="_blank" class="btn btn-sm btn-light-primary">
                                        Lihat File
                                    </a>
                                    <span id="detail_file_sk_masuk_name" class="ms-3 text-muted"></span>
                                </div>
                            </div>
                            <div id="no_file_sk_masuk_section" style="display: none;">
                                <div class="alert alert-warning">
                                    Tidak ada file sk_masuk yang diupload.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File SK Keluar</label>
                            <div id="detail_file_sk_keluar_section">
                                <div class="d-flex align-items-center mb-3">
                                    <a href="#" id="detail_file_sk_keluar_link" target="_blank" class="btn btn-sm btn-light-primary">
                                        Lihat File
                                    </a>
                                    <span id="detail_file_sk_keluar_name" class="ms-3 text-muted"></span>
                                </div>
                            </div>
                            <div id="no_file_sk_keluar_section" style="display: none;">
                                <div class="alert alert-warning">
                                    Tidak ada file sk keluar yang diupload.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">

                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>