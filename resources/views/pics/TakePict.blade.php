@extends('layouts.main')

@section('title', 'Ambil Foto')
@section('breadcrumb-item', 'pics')

@section('breadcrumb-item-active', 'Ambil Foto')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
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
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h5>Data Diri</h5>
                </div>
                <div class="card-body">
                    <form class="updateCandidate" id="updateCandidate" method="POST">
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
                            <input type="text" class="form-control" name="inputJobLevel" id="inputJobLevel"
                                placeholder="Level Karyawan" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputDepartment">Departemen</label>
                            <input type="text" class="form-control" name="inputDepartment" id="inputDepartment"
                                placeholder="Departemen" required />
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputFirstWorkDay">Tanggal Masuk</label>
                                <input type="date" class="form-control" name="inputFirstWorkDay" id="inputFirstWorkDay"
                                    required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputPictNumber">No. Foto</label>
                                <input type="number" class="form-control" name="inputPictNumber" id="inputPictNumber" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script>
        const candidateIdDisplay = document.getElementById('candidateIdDisplay');
        const inputName = document.getElementById('inputName');

        const candidateChoices = new Choices(inputName, {
            searchPlaceholderValue: 'Search for a candidate',
            shouldSort: false,
        });

        candidateChoices
            .setChoices(() =>
                fetch('/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputName').addEventListener('change', function() {
                    const selectedChoice = candidateChoices.getValue(); // single object

                    if (selectedChoice && selectedChoice.customProperties) {
                        candidateIdDisplay.value = selectedChoice.customProperties.candidateID;
                    } else {
                        candidateIdDisplay.value = '';
                    }
                });

            });
    </script>

    <script>
        data_uri_update = "";
        // Configure the webcam
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        function take_snapshot() {
            Webcam.snap(function(data_uri_update) {
                // Show the preview
                document.getElementById('preview_edit').src = data_uri_update;
                document.getElementById('preview_edit').style.display = 'block';
                document.getElementById('preview_edit').innerHTML = '<img src="' + data_uri_update + '"/>';
                // Simpan data URI ke dalam input hidden
                document.getElementById('imagePath_edit').value =
                    data_uri_update; // Menyimpan data URI ke input hidden
            });
        }

        $(document).ready(function() {

            const checkbox = document.getElementById('myCheckbox');
            const myDiv = document.getElementById('myDiv');
            const shuterBtn = document.getElementById('captureBtn');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    myDiv.classList.remove('hidden');
                    shuterBtn.classList.remove('hidden');
                    // Attach the webcam to the div
                    Webcam.attach('#my_camera');
                } else {
                    myDiv.classList.add('hidden');
                    shuterBtn.classList.add('hidden');
                    Webcam.reset('#my_camera');
                }
            });

            // Update form submit
            $('#updateCandidate').on('submit', function(e) {
                e.preventDefault();
                var id = $('#candidateIdDisplay').val();
                var imageData_update = $('#imagePath_edit').val();
                // Buat payload JSON
                var payload_update = {
                    id: id,
                    name: $('#nama_edit').val(),
                    job_level: $('#level_edit').val(),
                    department: $('#workplace_edit').val(),
                    birthplace: $('#tempat_lahir_edit').val(),
                    birthdate: $('#tgl_lahir_edit').val(),
                    first_work_day: $('#tgl_masuk_edit').val(),
                    pict_number: $('#no_foto_edit').val(),
                    foto: imageData_update
                };
                // console.log(payload_update);
                $.ajax({
                    url: '/api/karyawan/update/' + id,
                    type: 'POST',
                    // type: 'application/json',
                    data: payload_update,
                    success: function(response) {
                        // console.log(response);
                        var calon_option = ``;
                        for (let kl = 0; kl < response.length; kl++) {
                            calon_option += `<option value="` + response[kl].id + `"> Nama : ` +
                                response[kl].nama + ` | TEMPAT LAHIR : ` + response[kl]
                                .tempat_lahir + ` | TGL LAHIR : ` + response[kl].tgl_lahir +
                                `</option>`;
                        }
                        document.getElementById('nama_edit2').innerHTML = calon_option;
                        document.getElementById('my_camera_edit').style.display = "none";
                        Webcam.reset('#my_camera_edit');
                        document.getElementById('myCheckbox_edit').checked = false;
                        toastr.success('Data berhasil diperbarui.');
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                alert(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });

            });
        });
    </script>



@endsection
