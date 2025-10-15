@extends('layouts.main')

@section('title', 'Add ID Card Template')
@section('breadcrumb-item', 'Settings')

@section('breadcrumb-item-active', 'Add ID Card Template')

@section('css')
@endsection

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit ID Card</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-lg-4 col-form-label text-lg-end">Upload Template:</label>
                        <div class="col-lg-6">
                            <input name="file" id="input-file" type="file" class="form-control"
                                data-bouncer-target="#file-error-msg" required />
                            <small id="file-error-msg" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-lg-4 col-form-label text-lg-end">CTPAT</label>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ctpat" id="ctpat-1" required />
                                <label class="form-check-label" for="ctpat-1"> Yes </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ctpat" id="ctpat-2" required />
                                <label class="form-check-label" for="ctpat-2"> No </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-4 col-form-label text-lg-end">Departemen</label>
                        <div class="col-lg-6">
                            <div class="row">
                                @foreach ($departments as $department)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="departments[]"
                                                id="department-{{ $department->id }}" value="{{ $department->department_name }}">
                                            <label class="form-check-label"
                                                for="department-{{ $department->id }}">{{ $department->department_name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-4 col-form-label text-lg-end">Job Level</label>
                        <div class="col-lg-6">
                            <div class="row">
                                @foreach ($joblevels as $joblevel)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="job_levels[]"
                                                id="joblevel-{{ $joblevel->id }}" value="{{ $joblevel->level_name }}">
                                            <label class="form-check-label"
                                                for="joblevel-{{ $joblevel->id }}">{{ $joblevel->level_name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary me-2" id="saveTemplate">Submit</button>
                    <button class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection

@section('scripts')
@endsection
