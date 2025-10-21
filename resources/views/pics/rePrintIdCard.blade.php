@extends('layouts.main')

@section('title', 'Cetak Ulang')
@section('breadcrumb-item', 'PICS Cetak Ulang')

@section('breadcrumb-item-active', 'Cetak Ulang Kartu ID')


@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/autoFill.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/keyTable.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/uppy.min.css') }}">
    <style>
        .table-scrollable-down {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <style>
        .uppy-Dashboard-inner {
            max-height: 350px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Cari Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" placeholder="Cari NIK atau Nama Karyawan" />
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-grid d-sm-inline-block">
                                <button class="btn btn-primary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="search-result">
                    <div class="card-header">
                        <h5>Hasil Pencarian</h5>
                    </div>
                    <div class="card-body table-scrollable-down">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1234567890</td>
                                    <td>John Doe</td>
                                    <td>IT</td>
                                    <td>Developer</td>
                                    <td><button class="btn btn-success btn-sm">Cetak Ulang</button></td>
                                </tr>
                                <tr>
                                    <td>0987654321</td>
                                    <td>Jane Smith</td>
                                    <td>HR</td>
                                    <td>Manager</td>
                                    <td><button class="btn btn-success btn-sm">Cetak Ulang</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.select.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/uppy.min.js') }}"></script>

@endsection
