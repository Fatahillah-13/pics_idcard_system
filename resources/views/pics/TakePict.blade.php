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
                    <div class="col-xl-12" id="myDiv">
                        <div id="my_camera" class="">
                            <img src="{{ asset('assets/img/picture_icon2.png') }}" alt="picture" srcset=""
                                height="300px" width="400px">
                        </div>
                        <div class="mt-2 col-xl-12" id="buttonShutter" style="display: none;">
                            <button type="button" class="btn btn-secondary d-inline-flex"><i
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
        // Configure a few settings and attach camera
        Webcam.set({
            width: 500,
            height: 300,
            dest_width: 500,
            fps: 60,
            image_format: 'jpeg',
            jpeg_quality: 90
        });


        // A function to handle the snapshot and display it in the preview div
        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                document.getElementById('my_camera').innerHTML = '<img src="' + data_uri + '"/>';
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
@endsection
