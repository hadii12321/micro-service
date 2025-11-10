<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.keluarga.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama_anggota').text(response.data.nama_anggota);
                    $('#detail_nik_anggota').text(response.data.nik_anggota);
                    $('#detail_hubungan').text(response.data.hubungan);
                    $('#detail_status_tanggungan').text(response.data.status_tanggungan);
                    $('#detail_pekerjaan').text(response.data.pekerjaan);
                    $('#detail_pendidikan_terakhir').text(response.data.pendidikan_terakhir);
                    $('#detail_penghasilan').text(response.data.penghasilan ? 'Rp ' + new Intl.NumberFormat('id-ID').format(response.data.penghasilan) : '-');
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>