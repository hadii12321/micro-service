<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.master.jabatan.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    fetchDataDropdown('{{ route('api.master.unit') }}', '#edit_id_unit', 'unit', 'unit', () => {
                        $('#edit_id_unit').val(response.data.id_unit).trigger('change');
                    });
                     fetchDataDropdown('{{ route('api.master.periode') }}', '#edit_id_periode', 'periode', 'periode', () => {
                        $('#edit_id_periode').val(response.data.id_periode).trigger('change');
                    });
                     fetchDataDropdown('{{ route('api.ref.eselon') }}', '#edit_id_eselon', 'eselon', 'eselon', () => {
                        $('#edit_id_eselon').val(response.data.id_eselon).trigger('change');
                    });
                    $('#edit_jabatan').val(response.data.jabatan);
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
                        id_unit: $('#edit_id_unit').val(),
                        jabatan: $('#edit_jabatan').val(),
                        id_eselon: $('#edit_id_eselon').val(),
                        id_periode: $('#edit_id_periode').val(),
                    };
                    const update = '{{ route('admin.master.jabatan.update', [':id']) }}';
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
            });
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>
