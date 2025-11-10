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
                url: '{{ route('admin.person.list') }}',
                cache: false,
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
                    data: 'jk',
                    name: 'jk',
                    render: function (data) {
                        return data === 'L' ? 'Laki-laki' : (data === 'P' ? 'Perempuan' : data);
                    }
                },
                {
                    data: 'tempat_lahir',
                    name: 'tempat_lahir'
                },
                {
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir',
                    render: function (data) {
                        return data == null ? '' : formatter.formatDate(data);
                    }
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nomor_hp',
                    name: 'nomor_hp'
                },
                {
                    data: 'email',
                    name: 'email'
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
