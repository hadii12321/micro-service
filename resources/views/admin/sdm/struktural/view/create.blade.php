<!-- Modal Create -->
<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">

                    Tambah Struktural
                </h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <form method="post" id="bt_submit_create" enctype="multipart/form-data" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="uuid_person" value="{{ $id }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Unit</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="id_unit"
                                        name="id_unit"
                                        data-placeholder="Pilih Unit"
                                        data-allow-clear="true" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Jabatan</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="id_jabatan"
                                        name="id_jabatan"
                                        data-placeholder="Pilih Jabatan"
                                        data-allow-clear="true" required
                                        disabled>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Nomor SK</label>
                                <input type="text" name="nomor_sk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="nomor_sk" placeholder="Masukkan nomor SK" maxlength="50" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Tanggal
                                    SK</label>
                                <input type="text" name="tanggal_sk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="tanggal_sk" placeholder="Pilih tanggal Masuk" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Tanggal
                                    Masuk</label>
                                <input type="text" name="tanggal_masuk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="tanggal_masuk" placeholder="Pilih tanggal SK" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Masa Jabatan (Tahun)</label>
                                <input type="number" name="masa_jabatan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="masa_jabatan" placeholder="Masukkan masa jabatan" min="0" max="80">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-4">
                            <h6 class="text-muted modal-title">Data Keluar (Opsional)</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Tanggal
                                    Keluar</label>
                                <input type="text" name="tanggal_keluar"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="tanggal_keluar" placeholder="Pilih tanggal keluar">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">SK
                                    Pemberhentian</label>
                                <input type="text" name="sk_pemberhentian"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="sk_pemberhentian" placeholder="Masukkan nomor SK pemberhentian"
                                       maxlength="50">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Alasan
                                    Keluar</label>
                                <textarea name="alasan_keluar"
                                          class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          id="alasan_keluar" placeholder="Masukkan alasan keluar" rows="2"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">Keterangan</label>
                                <textarea name="keterangan"
                                          class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          id="keterangan" placeholder="Masukkan keterangan" rows="2"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File SK Masuk</label>
                                <input type="file" id="file_sk_masuk" name="file_sk_masuk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png" >
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File SK Keluar</label>
                                <input type="file" id="file_sk_keluar" name="file_sk_keluar"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
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