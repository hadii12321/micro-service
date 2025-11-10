<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.asuransi.show', ':id') }}";

        let edit_tanggal_mulai = $("#edit_tanggal_mulai").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        let edit_tanggal_berakhir = $("#edit_tanggal_berakhir").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_nama").text(data.nama);
                $("#edit_nik").text(data.nik);
                $("#edit_nomor_registrasi").val(data.nomor_registrasi);
                $("#edit_kartu_anggota").val(data.kartu_anggota);
                $("#edit_status_aktif").val(data.status_aktif).trigger('change');
                edit_tanggal_mulai.setDate(response.data.tanggal_mulai);
                edit_tanggal_berakhir.setDate(response.data.tanggal_berakhir);
                $("#edit_keterangan").val(data.keterangan);

                fetchDataDropdown("{{ route('api.ref.jenis-asuransi') }}", "#edit_id_jenis_asuransi", "jenis_asuransi", "jenis_asuransi", function () {
                    $("#edit_id_jenis_asuransi").val(data.id_jenis_asuransi).trigger("change");
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

            // Validation for required fields
            if (!$('#edit_id_jenis_asuransi').val()) {
                Swal.fire('Warning', 'Jenis Asuransi wajib dipilih', 'warning');
                $('#edit_id_jenis_asuransi').focus();
                return;
            }

            const updateUrl = "{{ route('admin.sdm.asuransi.update', ':id') }}".replace(":id", id);
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
                    const input = {
                        "id_jenis_asuransi": $("#edit_id_jenis_asuransi").val(),
                        "nomor_registrasi": $("#edit_nomor_registrasi").val(),
                        "kartu_anggota": $("#edit_kartu_anggota").val(),
                        "status_aktif": $("#edit_status_aktif").val(),
                        "tanggal_mulai": $("#edit_tanggal_mulai").val(),
                        "tanggal_berakhir": $("#edit_tanggal_berakhir").val(),
                        "keterangan": $("#edit_keterangan").val(),
                    };
                    DataManager.postData(updateUrl, input).then(response => {
                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
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