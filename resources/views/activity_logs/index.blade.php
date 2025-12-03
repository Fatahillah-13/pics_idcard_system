@extends('layouts.main')

@section('title', 'Riwayat Cetak ID Card')
@section('breadcrumb-item', 'Settings')

@section('breadcrumb-item-active', 'Riwayat Cetak ID Card Pegawai')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/autoFill.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/keyTable.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/uppy.min.css') }}">
@endsection


@section('content')
    <div class="container">
        <h1>Riwayat Aktivitas</h1>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Module</th>
                    <th>Target ID</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ optional($log->user)->name ?? '-' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->target_id }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip_address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data aktivitas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $logs->links() }}
    </div>
@endsection
