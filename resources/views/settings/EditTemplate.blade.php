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
                    <div class="row">
                        <div class="col-md-6">
                            @if ($cardTemplate->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset($cardTemplate->image_path) }}" alt="Template Image"
                                        style="max-width:300px; border:1px solid #ddd;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label text-lg-end">Upload Template:</label>
                                <div class="col-lg-6">
                                    <input name="file" id="input-file-edit" type="file" class="form-control"
                                        data-bouncer-target="#file-error-msg" />
                                    <small id="file-error-msg" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label text-lg-end">CTPAT</label>
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ctpat-edit" id="ctpat-1"
                                            value="1" {{ $cardTemplate->ctpat === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ctpat-1">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ctpat-edit" id="ctpat-2"
                                            value="0" {{ $cardTemplate->ctpat === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ctpat-2">No</label>
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
                                                    <input class="form-check-input" type="checkbox"
                                                        name="departments-edit[]" id="department-{{ $department->id }}"
                                                        value="{{ $department->department_name }}"
                                                        {{ in_array($department->department_name, $selectedDepartments) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="department-edit-{{ $department->id }}">{{ $department->department_name }}</label>
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
                                                    <input class="form-check-input" type="checkbox" name="job_levels-edit[]"
                                                        id="joblevel-{{ $joblevel->id }}"
                                                        value="{{ $joblevel->level_name }}"
                                                        {{ in_array($joblevel->level_name, $selectedJoblevels) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="joblevel-edit-{{ $joblevel->id }}">{{ $joblevel->level_name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary me-2" id="saveTemplate-edit">Submit</button>
                    <button class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection

@section('scripts')
    <script>
        // JavaScript to handle form submission
        document.getElementById('saveTemplate-edit').addEventListener('click', function() {
            const id = '{{ $cardTemplate->id }}';
            const fileInput = document.getElementById('input-file-edit');
            const ctpatInputs = document.getElementsByName('ctpat-edit');
            const departmentInputs = document.getElementsByName('departments-edit[]');
            const jobLevelInputs = document.getElementsByName('job_levels-edit[]');

            // Validate CTPAT selection
            let ctpatValue = null;
            for (const input of ctpatInputs) {
                if (input.checked) {
                    ctpatValue = input.value;
                    break;
                }
            }
            if (ctpatValue === null) {
                alert('Please select a CTPAT option.');
                return;
            }

            // Collect selected departments
            const selectedDepartments = [];
            for (const input of departmentInputs) {
                if (input.checked) {
                    selectedDepartments.push(input.value);
                }
            }

            // Collect selected job levels
            const selectedJobLevels = [];
            for (const input of jobLevelInputs) {
                if (input.checked) {
                    selectedJobLevels.push(input.value);
                }
            }

            // Prepare form data
            const formData = new FormData();
            if (fileInput.files.length > 0) {
                formData.append('image_path', fileInput.files[0]);
            }
            formData.append('ctpat', ctpatValue);
            selectedDepartments.forEach(dep => formData.append('department[]', dep));
            selectedJobLevels.forEach(level => formData.append('job_level[]', level));

            // console.log('Form Data:', {
            //     file: formData.get('file'),
            //     ctpat: formData.get('ctpat'),
            //     departments: formData.getAll('department[]'),
            //     job_levels: formData.getAll('job_level[]'),
            // });

            // Send AJAX request to upload the template
            $.ajax({
                url: `/card-template/update/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Template updated successfully!');
                    window.location.href = '/candidate/idcard'; // Redirect to the gallery page
                },
                error: function(xhr, status, error) {
                    console.error('Error uploading template:', error);
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
