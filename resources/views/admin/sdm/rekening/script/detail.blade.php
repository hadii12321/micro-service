<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.rekening.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#detail_no_rekening").text(data.no_rekening);
                $("#detail_bank").text(data.bank);
                $("#detail_nama_pemilik").text(data.nama_pemilik);
                $("#detail_kode_bank").text(data.kode_bank);
                $("#detail_cabang_bank").text(data.cabang_bank);
                $("#detail_jenis_rekening").text(data.jenis_rekening || 'Tabungan');
                $("#detail_status_aktif").text(data.status_aktif || 'Aktif');
                $("#detail_rekening_utama").text(data.rekening_utama === 'y' ? 'Ya' : 'Tidak');
            } else {
                Swal.fire("Warning", response.message, "warning");
            }
        })
            .catch(error => {
                ErrorHandler.handleError(error);
            });
    });
</script>