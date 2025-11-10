<script defer>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.riwayat-pendidikan.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
                if (response.success) {
                    const data = response.data;

                    $("#detail_jenjang").text(data.jenjang_pendidikan);
                    $("#detail_nama_sekolah").text(data.nama_sekolah);
                    $("#detail_negara").text(data.negara || 'Indonesia');
                    $("#detail_status_sekolah").text(data.status_sekolah);
                    $("#detail_jurusan").text(data.jurusan);
                    $("#detail_nomor_induk").text(data.nomor_induk);
                    $("#detail_tahun_masuk").text(data.tahun_masuk);
                    $("#detail_tahun_lulus").text(data.tahun_lulus);
                    $("#detail_gelar_akademik").text(data.gelar_akademik);
                    $("#detail_bidang_studi").text(data.bidang_studi);
                    $("#detail_ipk").text(data.ipk ? parseFloat(data.ipk).toFixed(2) : '-');
                    $('#detail_tanggal_lulus').text(formatter.formatDate(data.tanggal_lulus) ?? '-');
                    $("#detail_jumlah_semester").text(data.jumlah_semester);
                    $("#detail_jumlah_sks").text(data.jumlah_sks);
                    $("#detail_nomor_ijazah").text(data.nomor_ijazah);
                    $("#detail_sumber_biaya").text(data.sumber_biaya);
                    $("#detail_nama_pembimbing").text(data.nama_pembimbing);
                    $("#detail_judul_tugas_akhir").text(data.judul_tugas_akhir);

                    if (data.file_ijazah) {
                        $('#detail_file_ijazah_name').text(data.file_ijazah);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'pendidikan')
                            .replace(':filename', data.file_ijazah);
                        $('#detail_file_ijazah_link').attr('href', fileUrl);
                        $('#detail_file_ijazah_section').show();
                        $('#no_file_ijazah_section').hide();
                    } else {
                        $('#detail_file_ijazah_section').hide();
                        $('#no_file_ijazah_section').show();
                    }
                    if (data.file_transkip) {
                        $('#detail_file_transkip_name').text(data.file_transkip);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'pendidikan')
                            .replace(':filename', data.file_transkip);
                        $('#detail_file_transkip_link').attr('href', fileUrl);
                        $('#detail_file_transkip_section').show();
                        $('#no_file_transkip_section').hide();
                    } else {
                        $('#detail_file_transkip_section').hide();
                        $('#no_file_transkip_section').show();
                    }
                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(error => {
                ErrorHandler.handleError(error);
            });
    });
</script>
