<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        // Don't reset here - let global cleaner handle it
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.person.show', [':id']) }}';

        let edit_tanggal_lahir = $('#edit_tanggal_lahir').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#edit_nama').val(response.data.nama);
                    $('#edit_jk').val(response.data.jk).trigger('change');
                    $('#edit_tempat_lahir').val(response.data.tempat_lahir);
                    edit_tanggal_lahir.setDate(response.data.tanggal_lahir);
                    $('#edit_nik').val(response.data.nik);
                    $('#edit_nomor_kk').val(response.data.nomor_kk);
                    $('#edit_alamat').val(response.data.alamat);
                    $('#edit_rt').val(response.data.rt);
                    $('#edit_rw').val(response.data.rw);
                    $('#edit_npwp').val(response.data.npwp);
                    $('#edit_nomor_hp').val(response.data.nomor_hp);
                    $('#edit_email').val(response.data.email);
                    $('#edit_kewarganegaraan').val(response.data.kewarganegaraan);
                    $('#edit_golongan_darah').val(response.data.golongan_darah).trigger('change');

                    // Handle foto preview
                    if (response.data.foto) {
                        const photoUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'person')
                            .replace(':filename', response.data.foto);
                        $('#edit_image_preview').css('background-image', `url('${photoUrl}')`);
                        $('#edit_image_preview').css('background-size', 'cover');
                        $('#edit_image_preview').css('background-position', 'center');
                    } else {
                        $('#edit_image_preview').css('background-image', '');
                        $('#edit_image_preview').css('background-size', 'contain');
                        $('#edit_image_preview').css('background-position', 'center');
                    }
                    fetchDataDropdown('{{ route('api.almt.provinsi') }}', '#edit_id_provinsi', 'provinsi', 'provinsi', () => {
                        $('#edit_id_provinsi').val(response.data.id_provinsi).trigger('change');
                        fetchDataDropdown(`{{ route('api.almt.kabupaten', ':id') }}`.replace(':id', response.data.id_provinsi), '#edit_id_kabupaten', 'kabupaten', 'kabupaten', () => {
                            $('#edit_id_kabupaten').val(response.data.id_kabupaten).trigger('change');
                             fetchDataDropdown(`{{ route('api.almt.kecamatan', ':id') }}`.replace(':id', response.data.id_kabupaten),'#edit_id_kecamatan', 'kecamatan', 'kecamatan', () => {
                                    $('#edit_id_kecamatan').val(response.data.id_kecamatan).trigger('change');
                                    fetchDataDropdown(`{{ route('api.almt.desa', ':id') }}`.replace(':id', response.data.id_kecamatan),'#edit_id_desa', 'desa', 'desa', () => {
                                            $('#edit_id_desa').val(response.data.id_desa).trigger('change');
                                    });
                                });
                         }); 
                        
                    });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });

        $('#edit_id_provinsi').off('change.edit').on('change.edit', function () {
            const provinsiId = $(this).val();
            $('#edit_id_kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#edit_id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#edit_id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsiId) {
                const kabupatenUrl = `{{ route('api.almt.kabupaten', ':id') }}`.replace(':id', provinsiId);
                fetchDataDropdown(kabupatenUrl, '#edit_id_kabupaten', 'kabupaten', 'kabupaten');
            }
        });

        $('#edit_id_kabupaten').off('change.edit').on('change.edit', function () {
            const kabupatenId = $(this).val();
            $('#edit_id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#edit_id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kabupatenId) {
                const kecamatanUrl = `{{ route('api.almt.kecamatan', ':id') }}`.replace(':id', kabupatenId);
                fetchDataDropdown(kecamatanUrl, '#edit_id_kecamatan', 'kecamatan', 'kecamatan');
            }
        });

        $('#edit_id_kecamatan').off('change.edit').on('change.edit', function () {
            const kecamatanId = $(this).val();
            $('#edit_id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kecamatanId) {
                const desaUrl = `{{ route('api.almt.desa', ':id') }}`.replace(':id', kecamatanId);
                fetchDataDropdown(desaUrl, '#edit_id_desa', 'desa', 'desa');
            }
        });

        $('#bt_submit_edit').off('submit').on('submit', function (e) {
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
                    formData.append('nama', $('#edit_nama').val());
                    formData.append('jk', $('#edit_jk').val());
                    formData.append('tempat_lahir', $('#edit_tempat_lahir').val());
                    formData.append('tanggal_lahir', $('#edit_tanggal_lahir').val());
                    formData.append('kewarganegaraan', $('#edit_kewarganegaraan').val());
                    formData.append('golongan_darah', $('#edit_golongan_darah').val());
                    formData.append('nik', $('#edit_nik').val());
                    formData.append('nomor_kk', $('#edit_nomor_kk').val());
                    formData.append('alamat', $('#edit_alamat').val());
                    formData.append('rt', $('#edit_rt').val());
                    formData.append('rw', $('#edit_rw').val());
                    formData.append('id_desa', $('#edit_id_desa').val());
                    formData.append('npwp', $('#edit_npwp').val());
                    formData.append('nomor_hp', $('#edit_nomor_hp').val());
                    formData.append('email', $('#edit_email').val());

                    const fileInput = $('#edit_foto')[0];
                    if (fileInput.files[0]) {
                        formData.append('foto', fileInput.files[0]);
                    }

                    const update = '{{ route('admin.person.update', [':id']) }}';
                    DataManager.formData(update.replace(':id', id), formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter(
                                'edit_');
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