<script defer>
    $("#form_create").on("show.bs.modal", function (e) {
        $("#tmt").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $("#tmt_pensiun").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $('#btn_search_person').on('click', function () {
            const nik = $('#search_nik').val().trim();

            if (!nik) {
                Swal.fire('Warning', 'Masukkan NIK terlebih dahulu', 'warning');
                return;
            }

            if (nik.length < 16) {
                Swal.fire('Warning', 'NIK harus 16 digit', 'warning');
                return;
            }

            $(this).prop('disabled', true).html('Searching...');
            DataManager.fetchData("{{ route('admin.sdm.sdm.find_by_nik', ':nik') }}".replace(':nik', nik))
                .then(response => {
                    $('#btn_search_person').prop('disabled', false).html('Cari Person');

                    if (response.success) {
                        const data = response.data;
                        $('#person_nama').text(data.nama);
                        $('#person_nik').text(data.nik);
                        $('#person_tempat_lahir').text(data.tempat_lahir);
                        $('#person_tanggal_lahir').text(formatter.formatDate(response.data.tanggal_lahir));
                        $('#person_alamat').text(`${data.desa}, ${data.kecamatan}, ${data.kabupaten}, ${data.provinsi}`.replace(/^,\s*|,\s*$/g, '').replace(/,\s*,/g, ','));
                        $('#id_person').val(data.id_person);
                        $('#person_info').show();
                        $('#sdm_form').show();
                        $('#btn_save').show();

                        Swal.fire('Success', 'Person ditemukan!', 'success');
                    } else {
                        Swal.fire('tidak ditemukan', response.message || 'Person dengan NIK tersebut tidak ditemukan', 'warning');
                    }
                })
                .catch(error => {
                    $('#btn_search_person').prop('disabled', false).html('Cari Person');
                    ErrorHandler.handleError(error);
                });
        });

        // Clear person search
        $('#btn_clear_person').on('click', function () {
            clearPersonSearch();
            Swal.fire('Info', 'Pencarian person dibersihkan', 'info');
        });

        $('#search_nik').on('keypress', function (e) {
            if (e.which == 13) {
                $('#btn_search_person').click();
            }
        });

        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();

            if (!$('#id_person').val()) {
                Swal.fire('Warning', 'Pilih person terlebih dahulu dengan mencari NIK', 'warning');
                return;
            }
           
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
                        "id_person": $("#id_person").val(),
                        "nomor_karpeg": $("#nomor_karpeg").val(),
                        "nomor_sk": $("#nomor_sk").val(),
                        "tmt": $("#tmt").val(),
                        "tmt_pensiun": $("#tmt_pensiun").val(),
                    };
                    const action = "{{ route('admin.sdm.sdm.store') }}";
                    DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'validasi bermasalah', 'warning');
                        }
                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
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
        clearPersonSearch();
    });

    function clearPersonSearch() {
        $('#person_info').hide();
        $('#sdm_form').hide();
        $('#btn_save').hide();
        $('#id_person').val('');
        $('#search_nik').val('');
        $('#person_nama, #person_nik, #person_tempat_lahir, #person_tanggal_lahir, #person_alamat').text('');
    }
</script>