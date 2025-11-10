@php use Carbon\Carbon; @endphp
@extends('admin.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('list')
    <li class="breadcrumb-item text-muted">SDM</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Riwayat Pendidikan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative rounded">
                            <img src="{{ $person->foto !== null ? route('admin.view-file', ['person', $person->foto]) : asset('assets/media/logos/preview.png') }}"
                                 alt="Profile Image"
                                 class="w-125px h-125px object-fit-cover rounded">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="d-flex align-items-center mb-3">
                                    <h2 class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                        {{ $person->nama ?? 'Nama tidak tersedia' }}
                                    </h2>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center text-gray-600">
                                            <span class="fs-7">NIK: {{ $person->nik ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center text-gray-600">
                                            <span class="fs-7">No. KK: {{ $person->nomor_kk ?? '-' }}</span>
                                        </div>
                                    </div>
                                    @if ($person->npwp)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">NPWP: {{ $person->npwp }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($person->nomor_hp)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">HP: {{ $person->nomor_hp }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($person->tempat_lahir || $person->tanggal_lahir)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">
                                                    {{ $person->tempat_lahir ?? '' }}{{ $person->tempat_lahir && $person->tanggal_lahir ? ', ' : '' }}{{ $person->tanggal_lahir ? Carbon::parse($person->tanggal_lahir)->format('d M Y') : '' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $fullAddress = collect([
                                            $person->alamat,
                                            $person->desa,
                                            $person->kecamatan ? 'Kec. ' . $person->kecamatan : null,
                                            $person->kabupaten,
                                            $person->provinsi,
                                        ])
                                            ->filter()
                                            ->implode(', ');
                                    @endphp
                                    @if ($fullAddress)
                                        <div class="col-12">
                                            <div class="d-flex align-items-start text-gray-600">
                                                <span class="fs-7">{{ $fullAddress }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-wrapper mb-6">
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-semibold flex-nowrap overflow-auto">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 text-nowrap"
                               href="{{ route('admin.sdm.sdm.histori', ['id' => $id]) }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 active text-nowrap"
                               href="{{ route('admin.sdm.riwayat-pendidikan.index', ['id' => $id]) }}">Pendidikan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 text-nowrap"
                               href="{{ route('admin.sdm.keluarga.index', ['id' => $id]) }}">Keluarga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 text-nowrap"
                               href="{{ route('admin.sdm.asuransi.index', ['id' => $id]) }}">Asuransi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 text-nowrap"
                               href="{{ route('admin.sdm.rekening.index', ['id' => $id]) }}">Rekening</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 text-nowrap"
                               href="{{ route('admin.sdm.struktural.index', ['id' => $id]) }}">Struktural</a>
                        </li>
                    </ul>
                </div>

                <div class="card-toolbar mb-4">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#form_create" title="Tambah Riwayat Pendidikan">
                            Tambah Riwayat Pendidikan
                        </button>
                    </div>
                </div>

                <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                    <div class="table-responsive">
                        <table id="example"
                               class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                <th class="min-w-75px ps-5">Aksi</th>
                                <th class="min-w-150px">Jenjang</th>
                                <th class="min-w-150px">Nama Sekolah</th>
                                <th class="min-w-120px">Negara</th>
                                <th class="min-w-100px">Status Sekolah</th>
                                <th class="min-w-120px">Jurusan</th>
                                <th class="min-w-100px">Tahun Lulus</th>
                                <th class="min-w-100px">Gelar</th>
                                <th class="min-w-80px">IPK</th>
                                <th class="min-w-120px">Tanggal Lulus</th>
                                <th class="min-w-120px">Ijazah</th>
                                <th class="min-w-120px">Traskip</th>
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
    @include('admin.sdm.riwayat_pendidikan.view.detail')
    @include('admin.sdm.riwayat_pendidikan.view.create')
    @include('admin.sdm.riwayat_pendidikan.view.edit')
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
    @include('admin.sdm.riwayat_pendidikan.script.list')
    @include('admin.sdm.riwayat_pendidikan.script.create')
    @include('admin.sdm.riwayat_pendidikan.script.edit')
    @include('admin.sdm.riwayat_pendidikan.script.detail')
    @include('admin.sdm.riwayat_pendidikan.script.delete')
@endsection