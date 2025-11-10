@extends('admin.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}">
@endsection
@section('list')
    <li class="breadcrumb-item text-muted">Master</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Jabatan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content flex-column-fluid">
            <div class="card mb-xl-8 mb-5 border-2 shadow">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder mb-1">Data Jabatan</span>
                    </h3>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <a type="button" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" data-bs-toggle="modal"
                               data-bs-target="#form_create" title="Tambah Jabatan">Tambah Jabatan</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                        <div class="row mb-8">
                            <p class="mb-2 fw-boldest fs-4 text-primary border-bottom border-primary border-start-dotted border-1">
                                Filter Data:
                            </p>
                            <div class="col-md-4 col-lg-4 mb-3">
                                <label for="list_id_unit" class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    Unit
                                </label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="list_id_unit"
                                        name="list_id_unit"
                                        data-placeholder="Pilih Unit"
                                        data-allow-clear="true"
                                        style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3">
                                <label for="list_id_eselon" class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    Eselon
                                </label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="list_id_eselon"
                                        name="list_id_eselon"
                                        data-placeholder="Pilih Eselon"
                                        data-allow-clear="true"
                                        style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3">
                                <label for="list_id_periode" class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    Periode
                                </label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="list_id_periode"
                                        name="list_id_periode"
                                        data-placeholder="Pilih Periode"
                                        data-allow-clear="true"
                                        style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <table id="example"
                               class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                <th class="min-w-75px ps-5">Aksi</th>
                                <th class="min-w-200px">Jabatan</th>
                                <th class="min-w-150px">Unit</th>
                                <th class="min-w-150px">Eselon</th>
                                <th class="min-w-150px">Periode</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-800 fw-bolder fs-sm-8 fs-lg-6">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.master.jabatan.view.detail')
    @include('admin.master.jabatan.view.create')
    @include('admin.master.jabatan.view.edit')
@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/print.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
    <script>
        function fetchDataDropdown(url, id, placeholder, name, callback) {
            DataManager.executeOperations(url, "admin_" + url, 120).then(response => {
                $(id).empty().append('<option></option>');
                if (response.success) {
                    response.data.forEach(item => {
                        $(id).append(`<option value="${item['id_' + placeholder]}">${item[name]}</option>`);
                    });
                    $(id).select2();
                    if (callback) {
                        callback();
                    }
                } else if (!response.errors) {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            });
        }
    </script>
    @include('admin.master.jabatan.script.list')
    @include('admin.master.jabatan.script.create')
    @include('admin.master.jabatan.script.edit')
    @include('admin.master.jabatan.script.detail')
@endsection
