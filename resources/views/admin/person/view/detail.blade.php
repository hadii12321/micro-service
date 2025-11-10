<div class="modal fade" id="form_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Person</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom 1: Foto -->
                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <h6 class="text-primary fw-bold mb-3">Foto Profil</h6>
                            <div id="detail_foto_section" class="text-center">
                                <div class="symbol symbol-150px symbol-fixed position-relative rounded border">
                                    <img id="detail_foto_preview"
                                         alt="Foto Person" class="w-150px h-150px object-fit-cover rounded"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2: Data Dasar -->
                    <div class="col-md-4">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Data Dasar</h6>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Nama</span>
                            </label>
                            <p id="detail_nama" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Jenis Kelamin</span>
                            </label>
                            <p id="detail_jk" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Tempat Lahir</span>
                            </label>
                            <p id="detail_tempat_lahir" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Tanggal Lahir</span>
                            </label>
                            <p id="detail_tanggal_lahir" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Kewarganegaraan</span>
                            </label>
                            <p id="detail_kewarganegaraan" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Golongan Darah</span>
                            </label>
                            <p id="detail_golongan_darah" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>NIK</span>
                            </label>
                            <p id="detail_nik" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Nomor KK</span>
                            </label>
                            <p id="detail_nomor_kk" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>NPWP</span>
                            </label>
                            <p id="detail_npwp" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Nomor HP</span>
                            </label>
                            <p id="detail_nomor_hp" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Email</span>
                            </label>
                            <p id="detail_email" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>
                    </div>

                    <!-- Kolom 3: Alamat -->
                    <div class="col-md-5">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Alamat</h6>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Alamat</span>
                            </label>
                            <p id="detail_alamat" class="fw-light fs-sm-8 fs-lg-6" style="min-height: 60px;"></p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="d-flex flex-column mb-3">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>RT</span>
                                    </label>
                                    <p id="detail_rt" class="fw-light fs-sm-8 fs-lg-6"></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column mb-3">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                        <span>RW</span>
                                    </label>
                                    <p id="detail_rw" class="fw-light fs-sm-8 fs-lg-6"></p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Provinsi</span>
                            </label>
                            <p id="detail_provinsi" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Kabupaten/Kota</span>
                            </label>
                            <p id="detail_kabupaten" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Kecamatan</span>
                            </label>
                            <p id="detail_kecamatan" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Desa/Kelurahan</span>
                            </label>
                            <p id="detail_desa" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                        aria-label="Close">Tutup
                </button>
            </div>
        </div>
    </div>
</div>