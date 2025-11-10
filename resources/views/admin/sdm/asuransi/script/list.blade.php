<script defer>
    function load_data() {
        fetchDataDropdown('{{ route('api.ref.jenis-asuransi') }}', '#list_id_jenis_asuransi', 'jenis_asuransi', 'jenis_asuransi');
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: 'lBfrtip',
            stateSave: true,
            stateDuration: -1,
            pageLength: 10,
            lengthMenu: [
                [10, 15, 20, 25],
                [10, 15, 20, 25]
            ],
            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Column visibility control',
                className: 'btn btn-sm btn-dark rounded-2',
                columns: ':not(.noVis)'
            },
                {
                    extend: 'csv',
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.sdm.asuransi.list', $id ?? '') }}',
                cache: false,
                data: function (d) {
                    d.id_jenis_asuransi = $('#list_id_jenis_asuransi').val();
                    d.status = $('#list_status').val();
                }
            },
            order: [],
            ordering: true,
            columns: [{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nomor_registrasi',
                    name: 'nomor_registrasi'
                },
                {
                    data: 'kartu_anggota',
                    name: 'kartu_anggota'
                },
                {
                    data: 'jenis_asuransi',
                    name: 'jenis_asuransi'
                },
                {
                    data: 'nama_produk',
                    name: 'nama_produk'
                },
                {
                    data: 'status_aktif',
                    name: 'status_aktif'
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai',
                    render: function (data) {
                        return formatter.formatDate(data);
                    }
                },
                {
                    data: 'tanggal_berakhir',
                    name: 'tanggal_berakhir',
                    render: function (data) {
                        return formatter.formatDate(data);
                    }
                },
            ],
        });
        const performOptimizedSearch = _.debounce(function (query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error('Error during search:', error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });

        $('#list_id_jenis_asuransi').on('change', function () {
            rowsSelected = [];
            table.ajax.reload();
        });

        $('#list_status').on('change', function () {
            rowsSelected = [];
            table.ajax.reload();
        });
    }

    load_data();
</script>
