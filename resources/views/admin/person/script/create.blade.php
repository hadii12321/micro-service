<!-- tempatkan ini di atas script (sudah ada di view atau tambahkan) -->
<div id="alamatUrls"
     data-prov-url="{{ url('api/almt/provinsi') }}"
     data-kab-url="{{ url('api/almt/kabupaten') }}"
     data-kec-url="{{ url('api/almt/kecamatan') }}"
     data-desa-url="{{ url('api/almt/desa') }}" style="display:none"></div>
<script defer>
    $('#form_create').on('show.bs.modal', function (e) {

        $('#tanggal_lahir').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        fetchDataDropdown("{{ route('api.almt.provinsi') }}", "#id_provinsi", "provinsi", "provinsi");

        $('#id_provinsi').off('change').on('change', function () {
            const provinsiId = $(this).val();
            $('#id_kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsiId) {
                const kabupatenUrl = `{{ route('api.almt.kabupaten', ':id') }}`.replace(':id', provinsiId);
                fetchDataDropdown(kabupatenUrl, '#id_kabupaten', 'kabupaten', 'kabupaten');
            }
        });

        $('#id_kabupaten').off('change').on('change', function () {
            const kabupatenId = $(this).val();
            $('#id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kabupatenId) {
                const kecamatanUrl = `{{ route('api.almt.kecamatan', ':id') }}`.replace(':id', kabupatenId);
                fetchDataDropdown(kecamatanUrl, '#id_kecamatan', 'kecamatan', 'kecamatan');
            }
        });

        $('#id_kecamatan').off('change').on('change', function () {
            const kecamatanId = $(this).val();
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kecamatanId) {
                const desaUrl = `{{ route('api.almt.desa', ':id') }}`.replace(':id', kecamatanId);
                fetchDataDropdown(desaUrl, '#id_desa', 'desa', 'desa');
            }
        });

        $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false, allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append('nama', $('#nama').val());
                    formData.append('jk', $('#jk').val());
                    formData.append('tempat_lahir', $('#tempat_lahir').val());
                    formData.append('tanggal_lahir', $('#tanggal_lahir').val());
                    formData.append('kewarganegaraan', $('#kewarganegaraan').val());
                    formData.append('golongan_darah', $('#golongan_darah').val());
                    formData.append('nik', $('#nik').val());
                    formData.append('nomor_kk', $('#nomor_kk').val());
                    formData.append('alamat', $('#alamat').val());
                    formData.append('rt', $('#rt').val());
                    formData.append('rw', $('#rw').val());
                    formData.append('id_desa', $('#id_desa').val());
                    formData.append('npwp', $('#npwp').val());
                    formData.append('nomor_hp', $('#nomor_hp').val());
                    formData.append('email', $('#email').val());

                    const fileInput = $('#foto')[0];
                    if (fileInput.files[0]) {
                        formData.append('foto', fileInput.files[0]);
                    }

                    const action = "{{ route('admin.person.store') }}";
                    DataManager.formData(action, formData).then(response => {
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
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>