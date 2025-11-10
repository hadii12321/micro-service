<script defer>
    $("#form_create").on("show.bs.modal", function (e) {
        fetchDataDropdown("{{ route('api.ref.jenjang-pendidikan') }}", '#id_jenjang_pendidikan', 'jenjang_pendidikan', 'jenjang_pendidikan');

        $("#tanggal_lulus").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();
            const fileIjazahInput = document.getElementById('file_ijazah');
            const fileTranskipInput = document.getElementById('file_transkip');
            const fileIjazah = fileIjazahInput.files[0];
            const fileTranskip = fileTranskipInput.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            if (fileIjazah) {
                if (fileIjazah.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Ijazah tidak boleh lebih dari 10MB", "warning");
                    return;
                }
                if (!allowedTypes.includes(fileIjazah.type)) {
                    Swal.fire("Warning", "Format file Ijazah harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }

            }

            if (fileTranskip) {
                if (fileTranskip.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Transkip tidak boleh lebih dari 10MB", "warning");
                    return;
                }

                if (!allowedTypes.includes(fileTranskip.type)) {
                    Swal.fire("Warning", "Format file Transkip harus PDF, JPG, JPEG, atau PNG", "warning");
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
                    formData.append('uuid_person', '{{ $id }}');
                    formData.append('id_jenjang_pendidikan', $('#id_jenjang_pendidikan').val());
                    formData.append('nama_sekolah', $('#nama_sekolah').val());
                    formData.append('negara', $('#negara').val());
                    formData.append('status_sekolah', $('#status_sekolah').val());
                    formData.append('jurusan', $('#jurusan').val());
                    formData.append('nomor_induk', $('#nomor_induk').val());
                    formData.append('tahun_masuk', $('#tahun_masuk').val());
                    formData.append('tahun_lulus', $('#tahun_lulus').val());
                    formData.append('gelar_akademik', $('#gelar_akademik').val());
                    formData.append('bidang_studi', $('#bidang_studi').val());
                    formData.append('ipk', $('#ipk').val());
                    formData.append('tanggal_lulus', $('#tanggal_lulus').val());
                    formData.append('jumlah_semester', $('#jumlah_semester').val());
                    formData.append('jumlah_sks', $('#jumlah_sks').val());
                    formData.append('nomor_ijazah', $('#nomor_ijazah').val());
                    formData.append('judul_tugas_akhir', $('#judul_tugas_akhir').val());
                    formData.append('sumber_biaya', $('#sumber_biaya').val());
                    formData.append('nama_pembimbing', $('#nama_pembimbing').val());
                    if (fileIjazah) {     
                        formData.append('file_ijazah', fileIjazah);
                    }
                    if (fileTranskip) {
                        formData.append('file_transkip', fileTranskip);
                    }
                    const createUrl = "{{ route('admin.sdm.riwayat-pendidikan.store') }}";

                    DataManager.formData(createUrl, formData).then(response => {
                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "Validasi bermasalah", "warning");
                        }
                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
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