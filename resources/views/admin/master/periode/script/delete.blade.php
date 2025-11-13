<script defer>
    $('#form_delete_periode').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const nama = button.data("nama");

        // Set data ke modal delete
        $('#delete_nama_periode').text(nama);
        $('#delete_id_periode').val(id);
    });

    $('#bt_submit_delete_periode').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        const id = $('#delete_id_periode').val();
        const nama = $('#delete_nama_periode').text();

        Swal.fire({
            title: 'Hapus Data?',
            html: `Apakah Anda yakin ingin menghapus periode <strong>${nama}</strong>?<br>Data yang sudah dihapus tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: false,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                DataManager.openLoading();
                
                const deleteUrl = '{{ route('admin.master.periode.destroy', [':id']) }}'.replace(':id', id);
                
                DataManager.deleteData(deleteUrl)
                    .then(function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#3085d6'
                            });
                            $('#form_delete_periode').modal('hide');
                            
                            // Reload datatable
                            setTimeout(function () {
                                $('#example').DataTable().ajax.reload();
                            }, 1000);
                        } else {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }
                    })
                    .catch(function (error) {
                        ErrorHandler.handleError(error);
                    });
            }
        });
    });

    // Reset modal ketika ditutup
    $('#form_delete_periode').on('hidden.bs.modal', function () {
        $('#delete_nama_periode').text('');
        $('#delete_id_periode').val('');
    });
</script>