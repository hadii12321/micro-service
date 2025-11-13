<div class="modal fade" id="form_delete_periode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" id="bt_submit_delete_periode">
            @csrf
            @method('DELETE')
            <input type="hidden" id="delete_id_periode" name="id">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                        Hapus Data Periode
                    </h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="symbol symbol-100px symbol-circle mb-4">
                            <div class="symbol-label bg-light-danger">
                                <i class="bi bi-trash-fill text-danger fs-2hx"></i>
                            </div>
                        </div>
                        
                        <h4 class="text-dark mb-3">Konfirmasi Penghapusan</h4>
                        <div class="text-muted fw-semibold fs-6 mb-4">
                            Anda akan menghapus data periode:
                            <div class="text-dark fw-bold fs-4 mt-2" id="delete_nama_periode"></div>
                            <div class="text-danger mt-3">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    Tindakan ini tidak dapat dibatalkan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-light-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger fs-sm-8 fs-lg-6">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>