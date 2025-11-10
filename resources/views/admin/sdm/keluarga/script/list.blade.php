<script defer>
    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: "lBfrtip",
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
                    extend: "csv",
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
                {
                    extend: "excel",
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
                url: '{{ route('admin.sdm.keluarga.list', $id) }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
                {
                    data: 'nama_anggota',
                    name: 'nama_anggota'
                },
                {
                    data: 'nik_anggota',
                    name: 'nik_anggota'
                },
                {
                    data: 'hubungan',
                    name: 'hubungan'
                },
                {
                    data: 'status_tanggungan',
                    name: 'status_tanggungan',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'pendidikan_terakhir',
                    name: 'pendidikan_terakhir',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'penghasilan',
                    name: 'penghasilan',
                    render: function (data) {
                        if (!data || data === null || data === '') return '-';
                        try {
                            const number = parseFloat(data);
                            if (isNaN(number)) return '-';
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
                        } catch (e) {
                            return data;
                        }
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
                console.error("Error during search:", error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });

        $('#list_id_hubungan_keluarga').on('change', function () {
            rowsSelected = [];
            table.ajax.reload();
        });
    }

    load_data();
</script>
