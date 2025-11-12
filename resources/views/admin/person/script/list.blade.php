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
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Tombol Aksi - Detail, Edit, Delete
                    return `
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm btn-detail" data-bs-toggle="modal" 
                                    data-bs-target="#form_detail" data-id="${data}" title="Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" 
                                    data-bs-target="#form_edit" data-id="${data}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal" 
                                    data-bs-target="#form_delete" data-id="${data}" data-nama="${row.nama}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                }
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