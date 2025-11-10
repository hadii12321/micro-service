<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.master.jabatan.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $("#detail_unit").text(response.data.unit);
                    $("#detail_jabatan").text(response.data.jabatan);
                    $("#detail_eselon").text(response.data.eselon);
                    $("#detail_periode").text(response.data.periode);
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
