@extends('layouts.main')

@section('title', 'Ambil Foto')
@section('breadcrumb-item', 'PICS Pegawai Baru')

@section('breadcrumb-item-active', 'Ambil Foto')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <!-- [ Content-WebcamJS ] start -->
        <div class="col-md-6 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="md-3 col-mb-6 col-xl-6">
                            <h5>Ambil Foto</h5>
                        </div>
                        <div class="md-3 col-mb-6 col-xl-6">
                            <div class="form-check form-switch custom-switch-v1 form-check-inline float-end">
                                <input type="checkbox" class="form-check-input input-primary" id="customCheckinl1" />
                                <label class="form-check-label" for="customCheckinl1">Hidupkan Kamera</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12" id="myDiv">
                        <div id="my_camera" class="mb-3 col-md-6">
                            <img src="{{ asset('assets/img/picture_icon2.png') }}" alt="picture" srcset=""
                                height="300px" width="400px">
                        </div>
                        <div id="preview" class="mb-3 col-md-6" style="display: none;">
                            <img src="{{ asset('assets/img/picture_icon2.png') }}" alt="picture" srcset=""
                                height="300px" width="400px">
                        </div>
                        <div class="mt-2 col-xl-12" id="buttonShutter" style="display: none;">
                            <button type="button" class="btn btn-secondary d-inline-flex" onclick="take_snapshot()"><i
                                    class="ti ti-camera me-1"></i>Ambil Gambar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h5>Data Diri</h5>
                </div>
                <div class="card-body">
                    <form id="CandidateUpdateForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="inputName">Nama Lengkap</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select class="form-control" name="inputName" id="inputName">
                                    <option value="">Cari Kandidat</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" hidden>
                            <label class="form-label" for="candidateIdDisplay">ID</label>
                            <input type="text" class="form-control" value="" name="candidateIdDisplay"
                                id="candidateIdDisplay" required />
                        </div>
                        <div class="mb-3" hidden>
                            <label class="form-label" for="imagePath">ImagePath</label>
                            <input type="text" class="form-control" value="" name="imagePath" id="imagePath" />
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputBirthDate">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="inputBirthDate" id="inputBirthDate"
                                    required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputBirthPlace">Tempat Lahir</label>
                                <input type="text" class="form-control" name="inputBirthPlace" id="inputBirthPlace"
                                    placeholder="Tempat Lahir" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputJobLevel">Level Karyawan</label>
                            <select class="form-control" name="inputJobLevel" id="inputJobLevel">
                                <option value="">Pilih Level Karyawan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputDepartment">Departemen</label>
                            <select class="form-control" name="inputDepartment" id="inputDepartment">
                                <option value="">Pilih Departemen</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputFirstWorkDay">Tanggal Masuk</label>
                                <input type="date" class="form-control" name="inputFirstWorkDay"
                                    id="inputFirstWorkDay" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputPictNumber">No. Foto</label>
                                <input type="number" class="form-control" name="inputPictNumber"
                                    id="inputPictNumber" />
                            </div>
                        </div>
                        <button type="button" id="btn-simpan" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Content-Biodata ] end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    {{-- Department Choices JS --}}
    <script>
        const inputDepartment = document.getElementById('inputDepartment');

        const departmentChoices = new Choices(inputDepartment, {
            searchPlaceholderValue: 'Cari Departemen',
            shouldSort: false,
        });

        departmentChoices
            .setChoices(() =>
                fetch('/department/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputDepartment').addEventListener('change', function() {
                    const selectedChoice = departmentChoices.getValue(); // single object
                });

            });
    </script>
    {{-- Job Level Choices JS --}}
    <script>
        const inputJobLevel = document.getElementById('inputJobLevel');

        const jobLevelChoices = new Choices(inputJobLevel, {
            searchPlaceholderValue: 'Cari Level Karyawan',
            shouldSort: false,
        });

        jobLevelChoices
            .setChoices(() =>
                fetch('/joblevel/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputJobLevel').addEventListener('change', function() {
                    const selectedChoice = departmentChoices.getValue(); // single object
                });

            });
    </script>
    {{-- Auto Fill Based on Name Choices --}}
    <script>
        const candidateIdDisplay = document.getElementById('candidateIdDisplay');
        const candidateBirthplaceDisplay = document.getElementById('inputBirthPlace');
        const candidateBirthdateDisplay = document.getElementById('inputBirthDate');
        const candidateFirstWorkDayDisplay = document.getElementById('inputFirstWorkDay');
        const candidateJobLevelDisplay = document.getElementById('inputJobLevel');
        const candidateDepartmentDisplay = document.getElementById('inputDepartment');
        const candidatePictNumberDisplay = document.getElementById('inputPictNumber');
        const inputName = document.getElementById('inputName');

        const candidateChoices = new Choices(inputName, {
            searchPlaceholderValue: 'Search for a candidate',
            shouldSort: false,
        });

        candidateChoices
            .setChoices(() =>
                fetch('/candidate/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputName').addEventListener('change', function() {
                    const selectedChoice = candidateChoices.getValue(); // single object


                    if (selectedChoice && selectedChoice.customProperties) {
                        candidateIdDisplay.value = selectedChoice.customProperties.candidateID;
                        candidateBirthplaceDisplay.value = selectedChoice.customProperties.birthplace;
                        candidateBirthdateDisplay.value = selectedChoice.customProperties.birthdate;
                        candidateFirstWorkDayDisplay.value = selectedChoice.customProperties.first_working_day;
                        // Set Job Level select value and update Choices options if needed
                        candidateJobLevelDisplay.value = selectedChoice.customProperties.job_level;
                        jobLevelChoices.setChoiceByValue(selectedChoice.customProperties.job_level);

                        // Set Department select value and update Choices options if needed
                        candidateDepartmentDisplay.value = selectedChoice.customProperties.department;
                        departmentChoices.setChoiceByValue(selectedChoice.customProperties.department);
                        // Set Pict Number
                        candidatePictNumberDisplay.value = selectedChoice.customProperties.pict_number;
                    } else {
                        candidateIdDisplay.value = '';
                    }
                });

            });
    </script>
    {{-- WebcamJS --}}
    <script>
        // Configure a few settings and attach camera
        Webcam.set({
            width: 500,
            height: 300,
            dest_width: 500,
            fps: 60,
            image_format: 'jpeg',
            jpeg_quality: 90,
        });


        // A function to handle the snapshot and display it in the preview div
        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                // Show the preview
                document.getElementById('preview').src = data_uri;
                document.getElementById('preview').style.display = 'block';
                document.getElementById('preview').innerHTML = '<img src="' + data_uri + '"/>';

                // Simpan data URI ke dalam input hidden
                document.getElementById('imagePath').value = data_uri; // Menyimpan data URI ke input hidden

            });
        }

        // Add event listener to the checkbox
        document.getElementById('customCheckinl1').addEventListener('change', function() {
            if (this.checked) {
                Webcam.attach('#my_camera');
                // unhide the shutter button
                document.getElementById('buttonShutter').style.display = 'block';
            } else {
                Webcam.reset();
                document.getElementById('my_camera').innerHTML =
                    '<img src="{{ asset('assets/img/picture_icon2.png') }}" alt="picture" srcset="" height="300px" width="400px">';
                // unhide the shutter button
                document.getElementById('buttonShutter').style.display = 'none';
            }
        });
    </script>
    {{-- Update Logic --}}
    <script>
        $(document).ready(function() {
            // $('#CandidateUpdateForm').on('submit', function(event) {
            $('#btn-simpan').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var id = $('#candidateIdDisplay').val();

                // Get the form data
                var payload = {
                    name: $('#inputName').val(),
                    birthDate: $('#inputBirthDate').val(),
                    birthPlace: $('#inputBirthPlace').val(),
                    jobLevel: $('#inputJobLevel').val(),
                    department: $('#inputDepartment').val(),
                    firstWorkDay: $('#inputFirstWorkDay').val(),
                    pictNumber: $('#inputPictNumber').val(),
                    imagePath: $('#imagePath').val(), // Data URI from the preview
                };

                console.log('Payload:', payload);
                

                // Send the data using AJAX
                $.ajax({
                    url: '/candidate/update/' + id,
                    type: 'POST',
                    data: payload,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response
                        alert(response.message || 'Data berhasil disimpan!');

                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log('Error saving data:', error, status);
                        alert('Error saving data. Please try again.');
                    }
                });
                /*
                 */
            });
        });
    </script>
@endsection
