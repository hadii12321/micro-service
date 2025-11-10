<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.person.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama').text(response.data.nama);
                    $('#detail_jk').text(response.data.jk === 'L' ? 'Laki-laki' : (response.data.jk === 'P' ? 'Perempuan' : response.data.jk));
                    $('#detail_tempat_lahir').text(response.data.tempat_lahir);
                    $('#detail_tanggal_lahir').text(formatter.formatDate(response.data.tanggal_lahir));
                    $('#detail_kewarganegaraan').text(response.data.kewarganegaraan);
                    $('#detail_golongan_darah').text(response.data.golongan_darah);
                    $('#detail_nik').text(response.data.nik);
                    $('#detail_nomor_kk').text(response.data.nomor_kk);
                    $('#detail_alamat').text(response.data.alamat);
                    $('#detail_rt').text(response.data.rt);
                    $('#detail_rw').text(response.data.rw);
                    $('#detail_provinsi').text(response.data.provinsi);
                    $('#detail_kabupaten').text(response.data.kabupaten);
                    $('#detail_kecamatan').text(response.data.kecamatan);
                    $('#detail_desa').text(response.data.desa);
                    $('#detail_npwp').text(response.data.npwp);
                    $('#detail_nomor_hp').text(response.data.nomor_hp);
                    $('#detail_email').text(response.data.email);
                    // Handle foto display
                    if (response.data.foto) {
                        const photoUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'person')
                            .replace(':filename', response.data.foto);
                        $('#detail_foto_preview').attr('src', photoUrl);
                    } else {
                        $('#detail_foto_preview').attr('src', '');
                    }
                } else {
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>