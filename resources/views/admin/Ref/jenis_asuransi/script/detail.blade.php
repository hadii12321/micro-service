<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.ref.jenis-asuransi.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $("#detail_jenis_asuransi").text(response.data.jenis_asuransi);
                    $("#detail_nama_produk").text(response.data.nama_produk);
                    $("#detail_provider").text(response.data.provider);
                    $("#null_data").hide();
                    $("#show_data").show();
                } else {
                    $("#null_data").show();
                    $("#show_data").hide();
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>