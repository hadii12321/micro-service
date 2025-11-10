<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.keluarga.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_nama_anggota").text(data.nama_anggota);
                $("#edit_nik_anggota").text(data.nik_anggota);
                $("#edit_status_tanggungan").val(data.status_tanggungan).trigger('change');
                $("#edit_pekerjaan").val(data.pekerjaan);
                $("#edit_pendidikan_terakhir").val(data.pendidikan_terakhir);
                $("#edit_penghasilan").val(data.penghasilan);

                fetchDataDropdown("{{ route('api.ref.hubungan-keluarga') }}", "#edit_id_hubungan_keluarga", "hubungan_keluarga", "hubungan_keluarga", function () {
                    $("#edit_id_hubungan_keluarga").val(data.id_hubungan_keluarga).trigger("change");
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
            if (!$('#edit_id_hubungan_keluarga').val()) {
                Swal.fire('Warning', 'Hubungan Keluarga wajib dipilih', 'warning');
                $('#edit_id_hubungan_keluarga').focus();
                return;
            }

            const updateUrl = "{{ route('admin.sdm.keluarga.update', ':id') }}".replace(":id", id);
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
                        "id_hubungan_keluarga": $("#edit_id_hubungan_keluarga").val(),
                        "status_tanggungan": $("#edit_status_tanggungan").val(),
                        "pekerjaan": $("#edit_pekerjaan").val(),
                        "pendidikan_terakhir": $("#edit_pendidikan_terakhir").val(),
                        "penghasilan": $("#edit_penghasilan").val(),
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