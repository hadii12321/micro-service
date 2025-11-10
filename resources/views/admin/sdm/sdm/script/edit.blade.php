<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.sdm.show', ':id') }}";

        let edit_tmt = $("#edit_tmt").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        let edit_tmt_pensiun = $("#edit_tmt_pensiun").flatpickr({
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
                $("#edit_nomor_hp").text(data.nomor_hp);
                $("#edit_nomor_sk").val(data.nomor_sk);
                $('#edit_nomor_karpeg').val(response.data.nomor_karpeg);
                edit_tmt.setDate(response.data.tmt);
                edit_tmt_pensiun.setDate(response.data.tmt_pensiun);              
            } else {
                Swal.fire("Warning", response.message, "warning");
            }
        })
            .catch(error => {
                ErrorHandler.handleError(error);
            });

        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            const updateUrl = "{{ route('admin.sdm.sdm.update', ':id') }}".replace(":id", id);
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin memperbarui data ini?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false, allowEscapeKey: false,
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        "nomor_karpeg": $("#edit_nomor_karpeg").val(),
                        "nip": $("#edit_nip").val(),
                        "nomor_sk": $("#edit_nomor_sk").val(),
                        "tmt": $("#edit_tmt").val(),
                        "tmt_pensiun": $("#edit_tmt_pensiun").val(),
                    };
                    DataManager.postData(updateUrl, input).then(response => {
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
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
