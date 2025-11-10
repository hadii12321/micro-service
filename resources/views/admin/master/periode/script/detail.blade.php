<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.master.periode.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_periode').text(response.data.periode);
                    $('#detail_tanggal_awal').text(formatter.formatDate(response.data.tanggal_awal));
                    $('#detail_tanggal_akhir').text(formatter.formatDate(response.data.tanggal_akhir));
                    $('#detail_status').text(response.data.status === 'active' ? 'Aktif' : (response.data.status === 'block' ? 'Non Aktif' : response.data.status));
                    $('#null_data').hide();
                    $('#show_data').show();
                } else {
                    $('#null_data').show();
                    $('#show_data').hide();
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>
