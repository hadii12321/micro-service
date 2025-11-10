<script defer>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Kamu yakin?',
            text: "Ini akan dihapus secara permanen!",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false, allowEscapeKey: false,
            showCancelButton: true,
            cancelButtonColor: '#dd3333',
            confirmButtonText: 'Ya, Hapus!',
        }).then((result) => {
            if (result.value) {
                DataManager.openLoading();
                const destroy = '{{ route('admin.sdm.struktural.destroy', [':id']) }}';
                DataManager.deleteData(destroy.replace(':id', id)).then(response => {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                }).catch(error => {
                    ErrorHandler.handleError(error);
                });
            }
        });
    }
</script>