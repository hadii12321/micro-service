<script defer>
    fetchDataDropdown("{{ route('api.ref.eselon') }}", '#list_id_eselon', 'eselon', 'eselon');
    fetchDataDropdown("{{ route('api.master.periode') }}", '#list_id_periode', 'periode', 'periode');

    function load_data() {
        fetchDataDropdown('{{ route('api.master.unit') }}', '#list_id_unit', 'unit', 'unit');
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
                url: '{{ route('admin.master.jabatan.list') }}',
                cache: false,
                data: function(d) {
                    d.id_unit = $('#list_id_unit').val();
                    d.id_eselon = $('#list_id_eselon').val();
                    d.id_periode = $('#list_id_periode').val();
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
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'eselon',
                    name: 'eselon'
                },
                {
                    data: 'periode',
                    name: 'periode'
                },
            ]
        });

        const performOptimizedSearch = _.debounce(function(query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error('Error during search:', error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });

        $('#list_id_unit, #list_id_eselon, #list_id_periode').on('change', function() {
            rowsSelected = [];
            table.ajax.reload();
        });
    }

    load_data();
</script>
