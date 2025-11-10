<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        let edit_tanggal_awal = $('#edit_tanggal_awal').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        let edit_tanggal_akhir = $('#edit_tanggal_akhir').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        const detail = '{{ route('admin.master.periode.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#edit_periode').val(response.data.periode);
                    edit_tanggal_awal.setDate(response.data.tanggal_awal);
                    edit_tanggal_akhir.setDate(response.data.tanggal_akhir);
                    $('#edit_status').val(response.data.status).trigger('change');

                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });

        $('#bt_submit_edit').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        periode: $('#edit_periode').val(),
                        tanggal_awal: $('#edit_tanggal_awal').val(),
                        tanggal_akhir: $('#edit_tanggal_akhir').val(),
                        status: $('#edit_status').val(),
                    };
                    const update = '{{ route('admin.master.periode.update', [':id']) }}';
                    DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter('edit_');
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
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>
