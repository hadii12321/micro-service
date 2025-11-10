<script defer>
    $("#form_create").on("show.bs.modal", function (e) {
        fetchDataDropdown("{{ route('api.master.unit') }}", '#id_unit', 'unit', 'unit');

        $('#id_unit').on('change', function () {
            const unitId = $(this).val();
            $('#id_jabatan').empty().append('<option></option>').prop('disabled', true);
            if (unitId) {
                fetchDataDropdown("{{ route('api.master.jabatan') }}" + "?id_unit=" + unitId, '#id_jabatan', 'jabatan', 'jabatan', function () {
                    $('#id_jabatan').prop('disabled', false);
                });
            }
        });

        $("#tanggal_sk").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $("#tanggal_masuk").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $("#tanggal_keluar").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();
            const filesk_masukInput = document.getElementById('file_sk_masuk');
            const filesk_keluarInput = document.getElementById('file_sk_keluar');
            const filesk_masuk = filesk_masukInput.files[0];
            const filesk_keluar = filesk_keluarInput.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (filesk_masuk) {
                if (filesk_masuk.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file sk_masuk tidak boleh lebih dari 10MB", "warning");
                    return;
                }

                if (!allowedTypes.includes(filesk_masuk.type)) {
                    Swal.fire("Warning", "Format file sk_masuk harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }
            }

            if (filesk_keluar) {
                if (filesk_keluar.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file sk_keluar tidak boleh lebih dari 10MB", "warning");
                    return;
                }

                if (!allowedTypes.includes(filesk_keluar.type)) {
                    Swal.fire("Warning", "Format file sk_keluar harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }
            }

            Swal.fire({
                title: 'Kamu yakin?',
                text: "Apakah datanya benar dan apa yang anda inginkan?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false, allowEscapeKey: false,
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append("uuid_person", "{{ $id }}");
                    formData.append("id_unit", $("#id_unit").val());
                    formData.append("id_jabatan", $("#id_jabatan").val());
                    formData.append("nomor_sk", $("#nomor_sk").val());
                    formData.append("tanggal_sk", $("#tanggal_sk").val());
                    formData.append("tanggal_masuk", $("#tanggal_masuk").val());
                    formData.append("masa_jabatan", $("#masa_jabatan").val());
                    formData.append("tanggal_keluar", $("#tanggal_keluar").val());
                    formData.append("sk_pemberhentian", $("#sk_pemberhentian").val());
                    formData.append("alasan_keluar", $("#alasan_keluar").val());
                    formData.append("keterangan", $("#keterangan").val());
                    if (filesk_masuk) {
                        formData.append('file_sk_masuk', filesk_masuk);
                    }
                    if (filesk_keluar) {    
                        formData.append('file_sk_keluar', filesk_keluar);
                    }
                    const createUrl = "{{ route('admin.sdm.struktural.store') }}";

                    DataManager.formData(createUrl, formData).then(response => {
                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "validasi bermasalah", "warning");
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