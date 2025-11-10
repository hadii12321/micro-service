<script defer>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.struktural.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
                if (response.success) {
                    const data = response.data;
                    $("#detail_nama_unit").text(data.nama_unit);
                    $("#detail_nama_jabatan").text(data.nama_jabatan);
                    $("#detail_nomor_sk").text(data.nomor_sk);
                    $("#detail_tanggal_sk").text(formatter.formatDate(data.tanggal_sk));
                    $("#detail_tanggal_masuk").text(formatter.formatDate(data.tanggal_masuk));
                    $("#detail_eselon").text(data.eselon);
                    $("#detail_masa_jabatan").text(data.masa_jabatan);
                    $("#detail_tanggal_keluar").text(formatter.formatDate(data.tanggal_keluar));
                    $("#detail_sk_pemberhentian").text(data.sk_pemberhentian);
                    $("#detail_alasan_keluar").text(data.alasan_keluar);
                    $("#detail_keterangan").text(data.keterangan);
                    if (data.file_sk_masuk) {
                        $('#detail_file_sk_masuk_name').text(data.file_sk_masuk);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'struktural')
                            .replace(':filename', data.file_sk_masuk);
                        $('#detail_file_sk_masuk_link').attr('href', fileUrl);
                        $('#detail_file_sk_masuk_section').show();
                        $('#no_file_sk_masuk_section').hide();
                    } else {
                        $('#detail_file_sk_masuk_section').hide();
                        $('#no_file_sk_masuk_section').show();
                    }
                    if (data.file_sk_keluar) {
                        $('#detail_file_sk_keluar_name').text(data.file_sk_keluar);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'struktural')
                            .replace(':filename', data.file_sk_keluar);
                        $('#detail_file_sk_keluar_link').attr('href', fileUrl);
                        $('#detail_file_sk_keluar_section').show();
                        $('#no_file_sk_keluar_section').hide();
                    } else {
                        $('#detail_file_sk_keluar_section').hide();
                        $('#no_file_sk_keluar_section').show();
                    }
                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(error => {
                ErrorHandler.handleError(error);
            });
    })
</script>
