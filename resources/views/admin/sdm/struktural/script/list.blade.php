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
                url: '{{ route('admin.sdm.struktural.list', $id ?? '') }}',
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
                    data: 'nama_unit',
                    name: 'nama_unit',
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: 'nama_jabatan',
                    name: 'nama_jabatan',
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: 'nomor_sk',
                    name: 'nomor_sk'
                },
                {
                    data: 'tanggal_sk',
                    name: 'tanggal_sk',
                    render: function(data, type, row) {
                        return data == null ? "" : formatter.formatDate(data);
                    }
                },
                {
                    data: 'tanggal_masuk',
                    name: 'tanggal_masuk',
                    render: function(data, type, row) {
                        return data == null ? "" : formatter.formatDate(data);
                    }
                },
                {
                    data: 'eselon',
                    name: 'eselon',
                },
                {
                    data: 'masa_jabatan',
                    name: 'masa_jabatan',
                    render: function(data) {
                        return data ? data + ' tahun' : '-';
                    }
                },
                {
                    data: 'tanggal_keluar',
                    name: 'tanggal_keluar',
                    render: function(data, type, row) {
                        return data == null ? "" : formatter.formatDate(data);
                    }
                },
                {
                    data: 'file_sk_masuk',
                    name: 'file_sk_masuk',
                    render: function (data, type, row) {
                        if (data) {
                            const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                                .replace(':folder', 'struktural')
                                .replace(':filename', data);
                            return `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light-primary">Lihat</a>`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'file_sk_keluar',
                    name: 'file_sk_keluar',
                    render: function (data, type, row) {
                        if (data) {
                            const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                                .replace(':folder', 'struktural')
                                .replace(':filename', data);
                            return `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light-primary">Lihat</a>`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'periode',
                    name: 'periode',
                },
                {
                    data: 'is_latest',
                    name: 'is_latest',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge badge-success">Aktif</span>';
                        } else {
                            return '<span class="badge badge-secondary">Non-Aktif</span>';
                        }
                    }
                },
            ],
        });
        const performOptimizedSearch = _.debounce(function(query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error("Error during search:", error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });
    }

    load_data();
</script>
