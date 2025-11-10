<script defer>

    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.riwayat-pendidikan.show', ':id') }}";

        let edit_tanggal_lulus = $("#edit_tanggal_lulus").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_nama_sekolah").val(data.nama_sekolah);
                $("#edit_negara").val(data.negara);
                $("#edit_status_sekolah").val(data.status_sekolah).trigger('change');
                $("#edit_jurusan").val(data.jurusan);
                $("#edit_nomor_induk").val(data.nomor_induk);
                $("#edit_tahun_masuk").val(data.tahun_masuk);
                $("#edit_tahun_lulus").val(data.tahun_lulus);
                $("#edit_gelar_akademik").val(data.gelar_akademik);
                $("#edit_bidang_studi").val(data.bidang_studi);
                $("#edit_ipk").val(data.ipk);
                edit_tanggal_lulus.setDate(data.tanggal_lulus);
                $("#edit_jumlah_semester").val(data.jumlah_semester);
                $("#edit_jumlah_sks").val(data.jumlah_sks);
                $("#edit_nomor_ijazah").val(data.nomor_ijazah);
                $("#edit_judul_tugas_akhir").val(data.judul_tugas_akhir);
                $("#edit_sumber_biaya").val(data.sumber_biaya).trigger('change');
                $("#edit_nama_pembimbing").val(data.nama_pembimbing);
                if (data.file_ijazah) {
                    $('#current_file_ijazah_name').text(data.file_ijazah);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'pendidikan')
                        .replace(':filename', data.file_ijazah);
                    $('#current_file_ijazah_link').attr('href', fileUrl);
                    $('#current_file_ijazah_info').show();
                } else {
                    $('#current_file_ijazah_info').hide();
                }

                if (data.file_transkip) {
                    $('#current_file_transkip_name').text(data.file_transkip);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'pendidikan')
                        .replace(':filename', data.file_transkip);
                    $('#current_file_transkip_link').attr('href', fileUrl);
                    $('#current_file_transkip_info').show();
                } else {
                    $('#current_file_transkip_info').hide();
                }
                
                fetchDataDropdown("{{ route('api.ref.jenjang-pendidikan') }}", "#edit_id_jenjang_pendidikan", "jenjang_pendidikan", "jenjang_pendidikan", function () {
                    $("#edit_id_jenjang_pendidikan").val(data.id_jenjang_pendidikan).trigger("change");
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
            const fileIjazahInput = document.getElementById('edit_file_ijazah');
            const fileTranskipInput = document.getElementById('edit_file_transkip');
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
                    formData.append('id_jenjang_pendidikan', $('#edit_id_jenjang_pendidikan').val());
                    formData.append('nama_sekolah', $('#edit_nama_sekolah').val());
                    formData.append('negara', $('#edit_negara').val());
                    formData.append('status_sekolah', $('#edit_status_sekolah').val());
                    formData.append('jurusan', $('#edit_jurusan').val());
                    formData.append('nomor_induk', $('#edit_nomor_induk').val());
                    formData.append('tahun_masuk', $('#edit_tahun_masuk').val());
                    formData.append('tahun_lulus', $('#edit_tahun_lulus').val());
                    formData.append('gelar_akademik', $('#edit_gelar_akademik').val());
                    formData.append('bidang_studi', $('#edit_bidang_studi').val());
                    formData.append('ipk', $('#edit_ipk').val());
                    formData.append('tanggal_lulus', $('#edit_tanggal_lulus').val());
                    formData.append('jumlah_semester', $('#edit_jumlah_semester').val());
                    formData.append('jumlah_sks', $('#edit_jumlah_sks').val());
                    formData.append('nomor_ijazah', $('#edit_nomor_ijazah').val());
                    formData.append('judul_tugas_akhir', $('#edit_judul_tugas_akhir').val());
                    formData.append('sumber_biaya', $('#edit_sumber_biaya').val());
                    formData.append('nama_pembimbing', $('#edit_nama_pembimbing').val());
                    if (fileIjazah) {
                        formData.append('file_ijazah', fileIjazah);
                    }
                    if (fileTranskip) {
                        formData.append('file_transkip', fileTranskip);
                    }
                    const updateUrl = "{{ route('admin.sdm.riwayat-pendidikan.update', ':id') }}";
                    DataManager.formData(updateUrl.replace(":id", id), formData).then(response => {

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

                            console.error('Error creating dokumen:', error);
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