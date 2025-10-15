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
                    <h5>Tambah ID Card</h5>
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
    {{-- Upload File & Data --}}
    <script>
        document.getElementById('saveTemplate').addEventListener('click', function() {
            const fileInput = document.getElementById('input-file');
            // Get selected options as array of values
            const jobLevels = Array.from(document.querySelectorAll('input[name="job_levels[]"]:checked'))
                .map(cb => cb.value);
            const departments = Array.from(document.querySelectorAll('input[name="departments[]"]:checked'))
                .map(cb => cb.value);
            const ctpat = document.querySelector('input[name="ctpat"]:checked')?.id === 'ctpat-1' ? 1 : 0;

            if (!fileInput.files.length) {
                alert('File harus dipilih.');
                return;
            }
            if (!jobLevels.length) {
                alert('Level karyawan harus dipilih.');
                return;
            }
            if (!departments.length) {
                alert('Departemen harus dipilih.');
                return;
            }

            const formData = new FormData();
            formData.append('image_path', fileInput.files[0]); // 'image_path' must match controller
            // Append each value in the array
            jobLevels.forEach(level => formData.append('job_level[]', level));
            departments.forEach(dep => formData.append('department[]', dep));
            formData.append('ctpat', ctpat);

            $.ajax({
                url: '/card-template/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function(data) {
                    alert(data.success ? 'Template berhasil diupload!' : (data.message ||
                        'Gagal upload template.'));
                    if (data.success) location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat upload.');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

@endsection
