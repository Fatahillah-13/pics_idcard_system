@extends('layouts.main')

@section('title', 'Tambah Kandidat')
@section('breadcrumb-item', 'PICS Pegawai Baru')

@section('breadcrumb-item-active', 'Tambah Kandidat')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Tambah Kandidat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('candidate.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- <div class="col-12">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z">
                                            </path>
                                        </symbol>
                                    </svg>
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                        <use xlink:href="#info-fill"></use>
                                    </svg>
                                    <div> When working with the Bootstrap grid system, be sure to place form elements within
                                        column classes. </div>
                                </div>
                            </div> --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="inputName">Nama Lengkap</label>
                                <input type="text" class="form-control" name="inputName" id="inputName"
                                    placeholder="Nama Lengkap" required />
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
                            <div class="mb-3 col-md-5">
                                <label class="form-label" for="inputBirthDate">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="inputBirthDate" id="inputBirthDate"
                                    required />
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label" for="inputFirstWorkDay">Tanggal Masuk</label>
                                <input type="date" class="form-control" name="inputFirstWorkDay" id="inputFirstWorkDay"
                                    required />
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label" for="inputPictNumber">No. Foto</label>
                                <input type="number" class="form-control" name="inputPictNumber" id="inputPictNumber"
                                    value="{{ $nextPictNumber }}" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">+ Tambahkan Kandidat</button>
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
                    console.log(selectedChoice);
                });

            });
    </script>
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
                    console.log(selectedChoice);
                });

            });
    </script>
@endsection
