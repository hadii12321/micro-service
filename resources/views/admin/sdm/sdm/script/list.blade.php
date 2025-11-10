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
                url: '{{ route('admin.sdm.sdm.list') }}',
                cache: false,
                data: function(d) {
                    d.id_jenis_sdm = $('#list_id_jenis_sdm').val();
                    d.id_status_sdm = $('#list_id_status_sdm').val();
                }
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
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nomor_sk',
                    name: 'nomor_sk'
                },
                {
                    data: 'nomor_karpeg',
                    name: 'nomor_karpeg'
                },
                {
                    data: "tmt",
                    name: "tmt",
                    render: function(data) {
                        return data == null ? "" : formatter.formatDate(data);
                    }
                },
                {
                    data: "tmt_pensiun",
                    name: "tmt_pensiun",
                    render: function(data) {
                        return data == null ? "" : formatter.formatDate(data);
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
