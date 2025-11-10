<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Person</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom 1: Foto -->
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center mb-4">
                                <h6 class="text-primary fw-bold mb-3">Foto Profil</h6>
                                <div class="image-input image-input-outline" data-kt-image-input="true">
                                    <div class="image-input-wrapper w-150px h-150px rounded border"
                                         style="background-size: contain; background-repeat: no-repeat; background-position: center;"></div>

                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                           data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                           title="Ganti foto">
                                        <i class="bi bi-pencil fs-5">
                                        </i>
                                        <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png"/>
                                        <input type="hidden" name="foto_remove"/>
                                    </label>

                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                          data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                          title="Batal ganti foto">
                                        <i class="bi bi-trash fs-5">
                                        </i>
                                    </span>

                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                          data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                          title="Hapus foto">
                                        <i class="bi bi-trash fs-5">
                                        </i>
                                    </span>
                                </div>
                                <div class="form-text text-muted text-center mt-2">
                                    JPG, JPEG, PNG<br>Maksimal 2MB
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2: Data Dasar -->
                        <div class="col-md-4">
                            <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Data Dasar</h6>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Nama</span>
                                </label>
                                <input type="text" id="nama" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="50" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jenis Kelamin</span>
                                </label>
                                <select data-control="select2" id="jk"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tempat Lahir</span>
                                </label>
                                <input type="text" id="tempat_lahir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tanggal Lahir</span>
                                </label>
                                <input type="text" id="tanggal_lahir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Kewarganegaraan</span>
                                </label>
                                <input type="text" id="kewarganegaraan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Golongan Darah</span>
                                </label>
                                <select data-control="select2" id="golongan_darah"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Golongan Darah">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>NIK</span>
                                </label>
                                <input type="text" id="nik" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="16"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nomor KK</span>
                                </label>
                                <input type="text" id="nomor_kk" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="16"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>NPWP</span>
                                </label>
                                <input type="text" id="npwp" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nomor HP</span>
                                </label>
                                <input type="text" id="nomor_hp" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="16"/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Email</span>
                                </label>
                                <input type="text" id="email" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="100"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- Kolom 3: Alamat -->
                        <div class="col-md-5">
                            <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Alamat</h6>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Alamat</span>
                                </label>
                                <textarea id="alamat" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          maxlength="100" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex flex-column mb-2">
                                        <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                            <span>RT</span>
                                        </label>
                                        <input type="text" id="rt" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                               maxlength="3"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column mb-2">
                                        <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                            <span>RW</span>
                                        </label>
                                        <input type="text" id="rw" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                               maxlength="3"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Provinsi</span>
                                </label>
                                <select data-control="select2" id="id_provinsi"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                        data-allow-clear="true" data-placeholder="Pilih Provinsi">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Kabupaten/Kota</span>
                                </label>
                                <select data-control="select2" id="id_kabupaten"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                        data-allow-clear="true" data-placeholder="Pilih Kabupaten/Kota">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Kecamatan</span>
                                </label>
                                <select data-control="select2" id="id_kecamatan"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                        data-allow-clear="true" data-placeholder="Pilih Kecamatan">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Desa/Kelurahan</span>
                                </label>
                                <select data-control="select2" id="id_desa"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                        data-allow-clear="true" data-placeholder="Pilih Desa/Kelurahan">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">Close
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>