<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.struktural.show', ':id') }}";

        let edit_tanggal_sk = $("#edit_tanggal_sk").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        let edit_tanggal_masuk = $("#edit_tanggal_masuk").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        let edit_tanggal_keluar = $("#edit_tanggal_keluar").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_nomor_sk").val(data.nomor_sk);
                $("#edit_masa_jabatan").val(data.masa_jabatan);
                $("#edit_sk_pemberhentian").val(data.sk_pemberhentian);
                $("#edit_alasan_keluar").val(data.alasan_keluar);
                $("#edit_keterangan").val(data.keterangan);
                edit_tanggal_sk.setDate(data.tanggal_sk);
                edit_tanggal_masuk.setDate(data.tanggal_masuk);
                edit_tanggal_keluar.setDate(data.tanggal_keluar);
                if (data.file_sk_masuk) {
                    $('#current_file_sk_masuk_name').text(data.file_sk_masuk);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'struktural')
                        .replace(':filename', data.file_sk_masuk);
                    $('#current_file_sk_masuk_link').attr('href', fileUrl);
                    $('#current_file_sk_masuk_info').show();
                } else {
                    $('#current_file_sk_masuk_info').hide();
                }

                if (data.file_sk_keluar) {
                    $('#current_file_sk_keluar_name').text(data.file_sk_keluar);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'struktural')
                        .replace(':filename', data.file_sk_keluar);
                    $('#current_file_sk_keluar_link').attr('href', fileUrl);
                    $('#current_file_sk_keluar_info').show();
                } else {
                    $('#current_file_sk_keluar_info').hide();
                }
                fetchDataDropdown("{{ route('api.master.unit') }}", "#edit_id_unit", "unit", "unit",
                    function () {
                        $("#edit_id_unit").val(data.id_unit).trigger("change");
                        if (data.id_unit) {
                            fetchDataDropdown("{{ route('api.master.jabatan') }}" + "?id_unit=" +
                                data.id_unit, '#edit_id_jabatan', 'jabatan', 'jabatan', () => {
                                $("#edit_id_jabatan").val(data.id_jabatan).trigger(
                                    "change");
                            });
                        }
                    });
                $('#edit_id_unit').on('change', function () {
                    const unitId = $(this).val();
                    $('#edit_id_jabatan').empty().append('<option></option>').prop('disabled',
                        true);
                    if (unitId) {
                        fetchDataDropdown("{{ route('api.master.jabatan') }}" + "?id_unit=" +
                            unitId, '#edit_id_jabatan', 'jabatan', 'jabatan', function () {
                            $('#edit_id_jabatan').prop('disabled', false);
                        });
                    }
                });

            } else {
                Swal.fire("Warning", response.message, "warning");
            }
        })
            .catch(error => {
                ErrorHandler.handleError(error);
            });

        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            const filesk_masukInput = document.getElementById('edit_file_sk_masuk');
            const filesk_keluarInput = document.getElementById('edit_file_sk_keluar');
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
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true,
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append("id_unit", $("#edit_id_unit").val());
                    formData.append("id_jabatan", $("#edit_id_jabatan").val());
                    formData.append("nomor_sk", $("#edit_nomor_sk").val());
                    formData.append("tanggal_sk", $("#edit_tanggal_sk").val());
                    formData.append("tanggal_masuk", $("#edit_tanggal_masuk").val());
                    formData.append("masa_jabatan", $("#edit_masa_jabatan").val());
                    formData.append("tanggal_keluar", $("#edit_tanggal_keluar").val());
                    formData.append("sk_pemberhentian", $("#edit_sk_pemberhentian").val());
                    formData.append("alasan_keluar", $("#edit_alasan_keluar").val());
                    formData.append("keterangan", $("#edit_keterangan").val());
                    if (filesk_masuk) {
                        formData.append('file_sk_masuk', filesk_masuk);
                    }
                    if (filesk_keluar) {
                        formData.append('file_sk_keluar', filesk_keluar);
                    }
                    const updateUrl = "{{ route('admin.sdm.struktural.update', ':id') }}".replace(":id", id);
                    DataManager.formData(updateUrl, formData).then(response => {
                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_");
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
