@extends('admin.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}"/>
@endsection
@section('list')
    <li class="breadcrumb-item text-muted">Person</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Data Person</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="content flex-column-fluid">
            <div class="card mb-xl-8 mb-5 border-2 shadow">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder mb-1 ">Data Person</span>
                    </h3>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <a type="button" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" data-bs-toggle="modal"
                               data-bs-target="#form_create" title="Tambah Person">Tambah Person</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="notice d-flex border-primary mb-4 rounded border border-dashed p-4 shadow bg-hover-light-dark">
                        <div class="d-flex flex-stack fs-sm-8 fs-lg-6">
                            <div class="row">
                                <span class="text-gray-700">Berikut ini adalah data Person.</span>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                        <div class="table-responsive">
                            <table id="example"
                                   class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                    <th class="min-w-75px ps-5">Aksi</th>
                                    <th class="min-w-150px">Nama</th>
                                    <th class="min-w-60px">JK</th>
                                    <th class="min-w-120px">Tempat Lahir</th>
                                    <th class="min-w-100px">Tanggal Lahir</th>
                                    <th class="min-w-120px">NIK</th>
                                    <th class="min-w-100px">No. HP</th>
                                    <th class="min-w-100px">Email</th>
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
    </div>
    @include('admin.person.view.detail')
    @include('admin.person.view.create')
    @include('admin.person.view.edit')
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
            DataManager.executeOperations(url, 'admin_' + url, 120).then(response => {
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
    @include('admin.person.script.list')
    @include('admin.person.script.create')
    @include('admin.person.script.edit')
    @include('admin.person.script.detail')
@endsection