<script>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {

            if (!result.isConfirmed) return;

            DataManager.openLoading();

            const destroyUrl = '{{ route('admin.sdm.destroy', ':id') }}'
                .replace(':id', id);

            // Kirim request delete
            DataManager.postData(destroyUrl)
                .then(response => {
                    if (response.success) {
                        Swal.fire('Berhasil', response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Warning', response.message, 'warning');
                    }
                })
                .catch(error => {
                    ErrorHandler.handleError(error);
                });
        });
    }
</script>