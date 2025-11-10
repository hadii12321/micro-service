<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.sdm.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama').text(response.data.nama);
                    $('#detail_nik').text(response.data.nik);
                    $('#detail_nomor_hp').text(response.data.nomor_hp);
                    $('#detail_nomor_karpeg').text(response.data.nomor_karpeg);
                    $('#detail_nomor_sk').text(response.data.nomor_sk);
                    $('#detail_tmt').text(formatter.formatDate(response.data.tmt));
                    $('#detail_tmt_pensiun').text(formatter.formatDate(response.data.tmt_pensiun));
                } else {
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>