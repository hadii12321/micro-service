<script defer>
    function load_data() {
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
            buttons: [
                {
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
                    className: 'btn btn-sm btn-dark rounded-2'
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2'
                }
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.master.periode.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            rowCallback: function (row, data, dataIndex) {
                if (data.status !== 'active') {
                    $('td', row).css('color', '#a1081f');
                } else {
                    $('td', row).css('color', '#0b7a44');
                }
            },
            columns: [
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'periode',
                    name: 'periode'
                },
                {
                    data: 'tanggal_awal',
                    name: 'tanggal_awal',
                    render: function (data) {
                        return data == null ? '' : formatter.formatDate(data);
                    }
                },
                {
                    data: 'tanggal_akhir',
                    name: 'tanggal_akhir',
                    render: function (data) {
                        return data == null ? '' : formatter.formatDate(data);
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        return data === 'active' ? 'Aktif' : (data === 'block' ? 'Non Aktif' : data);
                    }
                }
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
    }

    load_data();
</script>
