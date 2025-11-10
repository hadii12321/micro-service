<script defer>
    $("#form_create").on("show.bs.modal", function (e) {
        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();

            // Validation for required fields based on controller requirements
            if (!$('#no_rekening').val()) {
                Swal.fire('Warning', 'Nomor rekening wajib diisi', 'warning');
                $('#no_rekening').focus();
                return;
            }
            if ($('#no_rekening').val().length > 25) {
                Swal.fire('Warning', 'Nomor rekening maksimal 25 karakter', 'warning');
                $('#no_rekening').focus();
                return;
            }
            if (!$('#bank').val()) {
                Swal.fire('Warning', 'Nama bank wajib diisi', 'warning');
                $('#bank').focus();
                return;
            }
            if ($('#bank').val().length > 50) {
                Swal.fire('Warning', 'Nama bank maksimal 50 karakter', 'warning');
                $('#bank').focus();
                return;
            }

            // Optional field length validations
            if ($('#nama_pemilik').val() && $('#nama_pemilik').val().length > 100) {
                Swal.fire('Warning', 'Nama pemilik maksimal 100 karakter', 'warning');
                $('#nama_pemilik').focus();
                return;
            }
            if ($('#kode_bank').val() && $('#kode_bank').val().length > 10) {
                Swal.fire('Warning', 'Kode bank maksimal 10 karakter', 'warning');
                $('#kode_bank').focus();
                return;
            }
            if ($('#cabang_bank').val() && $('#cabang_bank').val().length > 100) {
                Swal.fire('Warning', 'Cabang bank maksimal 100 karakter', 'warning');
                $('#cabang_bank').focus();
                return;
            }

            const createUrl = "{{ route('admin.sdm.rekening.store') }}";
            Swal.fire({
                title: 'Kamu yakin?',
                text: "Apakah datanya benar dan apa yang anda inginkan?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true,
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        "uuid_person": "{{ $id }}",
                        "no_rekening": $("#no_rekening").val(),
                        "bank": $("#bank").val(),
                        "nama_pemilik": $("#nama_pemilik").val(),
                        "kode_bank": $("#kode_bank").val(),
                        "cabang_bank": $("#cabang_bank").val(),
                        "jenis_rekening": $("#jenis_rekening").val(),
                        "status_aktif": $("#status_aktif").val(),
                        "rekening_utama": $("#rekening_utama").val(),
                    };

                    DataManager.postData(createUrl, input).then(response => {
                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "Validasi bermasalah", "warning");
                        } else {
                            Swal.fire("Warning", response.message, "warning");
                        }
                    })
                        .catch(error => {
                            ErrorHandler.handleError(error);
                        });

                }
            });
        });
    })
        .on("hidden.bs.modal", function () {
            const $m = $(this);
            $m.find('form').trigger('reset');
            $m.find('select, textarea').val('').trigger('change');
            $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
            $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
        });
</script>
