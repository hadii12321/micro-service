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
                url: '{{ route('admin.sdm.rekening.list', $id ?? '') }}',
                cache: false,
                data: function (d) {
                    d.status_aktif = $('#list_status_aktif').val();
                    d.jenis_rekening = $('#list_jenis_rekening').val();
                    d.rekening_utama = $('#list_rekening_utama').val();
                },
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
                    data: 'no_rekening',
                    name: 'no_rekening'
                },
                {
                    data: 'bank',
                    name: 'bank'
                },
                {
                    data: 'nama_pemilik',
                    name: 'nama_pemilik',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'kode_bank',
                    name: 'kode_bank',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'cabang_bank',
                    name: 'cabang_bank',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'jenis_rekening',
                    name: 'jenis_rekening',
                    render: function (data) {
                        return data || 'Tabungan';
                    }
                },
                {
                    data: 'status_aktif',
                    name: 'status_aktif',
                    render: function (data) {
                        const statusClass = {
                            'Aktif': 'badge-success',
                            'Nonaktif': 'badge-warning',
                            'Ditutup': 'badge-danger'
                        };
                        const cssClass = statusClass[data] || 'badge-secondary';
                        return `<span class="badge ${cssClass}">${data || 'Aktif'}</span>`;
                    }
                },
                {
                    data: 'rekening_utama',
                    name: 'rekening_utama',
                    render: function (data) {
                        return data === 'y' ? '<span class="badge badge-success">Ya</span>' :
                            '<span class="badge badge-secondary">Tidak</span>';
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

        // Filter event handlers
        $('#list_status_aktif, #list_jenis_rekening, #list_rekening_utama').on('change', function () {
            table.ajax.reload();
        });
    }

    load_data();
</script>
