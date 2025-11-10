<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.ref.jenis-asuransi.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $("#edit_jenis_asuransi").val(response.data.jenis_asuransi);
                    $("#edit_nama_produk").val(response.data.nama_produk);
                    $("#edit_provider").val(response.data.provider);
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });

        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: "Apakah datanya benar dan apa yang anda inginkan?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false, allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        "jenis_asuransi": $("#edit_jenis_asuransi").val(),
                        "nama_produk": $("#edit_nama_produk").val(),
                        "provider": $("#edit_provider").val()
                    };
                    const update = '{{ route('admin.ref.jenis-asuransi.update', [':id']) }}';
                    DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter(
                                "edit_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                        }

                        if (!response.success && !response.errors) {
                            Swal.fire('Warning', response.message, 'warning');
                        }
                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            })
        });
    }).on("hidden.bs.modal", function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>