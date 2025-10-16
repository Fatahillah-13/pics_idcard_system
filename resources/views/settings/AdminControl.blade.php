@extends('layouts.main')

@section('title', 'Admin Rights Control')
@section('breadcrumb-item', 'Settings')

@section('breadcrumb-item-active', 'Admin Rights Controls')

@section('css')
    <!-- map-vector css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Admin Rights Control</h5>
                <p>Click the button below to copy files from the source directory to the destination directory using the
                    Copy_API Python.</p>
            </div>
            <div class="card-body">
                <form action="/copy-files" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Copy File</button>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

@endsection

@section('scripts')

@endsection
