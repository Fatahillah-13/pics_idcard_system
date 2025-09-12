@extends('layouts.main')

@section('title', 'Tambah Kandidat')
@section('breadcrumb-item', 'PICS Pegawai Baru')

@section('breadcrumb-item-active', 'Tambah Kandidat')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/autoFill.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/keyTable.bootstrap5.min.css') }}">
@endsection

@section('content')
    {{-- Modal Add Candidate --}}
    <div class="modal fade bd-example-modal-lg" id="addCandidateModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah NIK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('candidate.store') }}" method="POST">
                        @csrf
                        <div class="row">
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
                                <input type="number" class="form-control" name="inputPictNumber" id="inputPictNumber" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">+ Tambahkan Kandidat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal View --}}
    <div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Detail Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="number" class="form-control" name="id" id="idCandidateEdit" hidden />
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="inputName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="inputNameEdit" id="inputNameEdit"
                                placeholder="Nama Lengkap" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="inputBirthPlace">Tempat Lahir</label>
                            <input type="text" class="form-control" name="inputBirthPlaceEdit"
                                id="inputBirthPlaceEdit" placeholder="Tempat Lahir" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputJobLevel">Level Karyawan</label>
                        <select class="form-control" name="inputJobLevelEdit" id="inputJobLevelEdit">
                            <option value="">Pilih Level Karyawan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputDepartment">Departemen</label>
                        <select class="form-control" name="inputDepartmentEdit" id="inputDepartmentEdit">
                            <option value="">Pilih Departemen</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-5">
                            <label class="form-label" for="inputBirthDate">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="inputBirthDateEdit" id="inputBirthDateEdit"
                                required />
                        </div>
                        <div class="mb-3 col-md-5">
                            <label class="form-label" for="inputFirstWorkDay">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="inputFirstWorkDayEdit"
                                id="inputFirstWorkDayEdit" required />
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="inputPictNumber">No. Foto</label>
                            <input type="number" class="form-control" name="inputPictNumberEdit"
                                id="inputPictNumberEdit" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="generateIDCardBtn" class="btn btn-primary"
                        onclick="submitCandidateForm()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Import Excel --}}
    <div class="modal fade bd-example-modal-sm" id="importExcelModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="mySmallModalLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('candidate.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="importFile" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control" name="importFile" id="importFile"
                                accept=".xlsx, .xls, .csv" required>
                        </div>
                        <a href="{{ asset('assets/doc/TemplateImport.xlsx') }}" class="btn btn-link">Download Template</a>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] start -->
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- Tabel Data --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="colum-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all" />
                                    </th>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Departemen</th>
                                    <th>Tanggal Masuk</th>
                                    <th>TTL</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.select.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.bootstrap5.min.js') }}"></script>
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
    {{-- Datatable JS --}}
    <script>
        // [ Autofill ]
        // $('#autofill').DataTable({
        //     autoFill: true
        // });
        // [ KeyTable Integration ]
        $('#key-integration').DataTable({
            keys: true,
            autoFill: true
        });
        // [ Column Selector ]
        $('#confirm-table').DataTable({
            autoFill: {
                alwaysAsk: true
            }
        });

        // [ scroll fill ]
        var safill = $('#scroll-fill').dataTable({
            scrollY: 400,
            scrollCollapse: true,
            paging: false,
        });
        let columSelectTable = $('#colum-select').DataTable({
            dom: 'Bfrtip',
            deferRender: true,
            scrollY: 600,
            scrollCollapse: true,
            scroller: true,
            buttons: [{
                    // Button to add NIK
                    text: '+ Tambah Kandidat',
                    className: 'btn btn-primary',
                    action: function(e, dt, node, config) {
                        const selectedData = dt.rows({
                            selected: true
                        }).data();
                        let selectedIds = [];

                        for (let i = 0; i < selectedData.length; i++) {
                            selectedIds.push(selectedData[i].id); // assuming your row has an 'id' field
                        }

                        // Open the modal to add NIK for selected candidates
                        $('#addCandidateModal').modal('show');
                    }
                },
                {
                    text: 'Import Excel',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {
                        // Open the import modal
                        $('#importExcelModal').modal('show');
                    }
                },
                {
                    text: 'Hapus',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        const selectedData = dt.rows({
                            selected: true
                        }).data();

                        // Collect selected IDs
                        const selectedIds = selectedData.map(row => row.id);

                        if (selectedIds.length === 0) {
                            alert('Tidak ada kandidat yang dipilih untuk dihapus.');
                            return;
                        }

                        if (confirm(
                                `Apakah Anda yakin ingin menghapus ${selectedIds.length} kandidat terpilih?`
                            )) {
                            $.ajax({
                                url: '/candidate/delete/' + selectedIds.join(','),
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alert('Kandidat berhasil dihapus.');
                                        columSelectTable.ajax.reload(); // Reload the DataTable
                                    } else {
                                        alert('Gagal menghapus kandidat. Silakan coba lagi.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error:', error);
                                    console.log(xhr.responseText);
                                    console.log(xhr.status);
                                    alert(
                                        'Terjadi kesalahan saat menghapus kandidat. Silakan coba lagi.'
                                    );
                                }
                            });
                        }
                    }
                }


            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ],
            ajax: '{{ route('candidate.new') }}',
            columns: [{
                    data: null,
                    defaultContent: ''
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'job_level'
                },
                {
                    data: 'department'
                },
                {
                    data: 'first_working_day',
                    render: function(data, type, row) {
                        if (!data) return '';
                        const months = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        let date = data.split('-');
                        if (date.length === 3) {
                            let day = date[2];
                            let month = months[parseInt(date[1], 10) - 1];
                            let year = date[0];
                            return `${day} ${month} ${year}`;
                        }
                        return data;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // Format birthdate from yyyy-mm-dd to dd-mm-yyyy
                        let date = row.birthdate ? row.birthdate.split('-') : [];
                        let formattedDate = date.length === 3 ? `${date[2]}-${date[1]}-${date[0]}` : row
                            .birthdate;
                        return `${row.birthplace}, ${formattedDate}`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<button type="button" class="btn btn-primary btn-sm" onclick="openViewModal(${row.id})">View</button>`;
                    }
                }
            ]
        });

        // Handle Select All checkbox click
        $('#select-all').on('click', function() {
            if (this.checked) {
                columSelectTable.rows({
                    search: 'applied'
                }).select();
            } else {
                columSelectTable.rows().deselect();
            }
        });

        // Update Select All checkbox when rows are selected/deselected
        columSelectTable.on('select deselect', function() {
            let allRows = columSelectTable.rows({
                search: 'applied'
            }).count();
            let selectedRows = columSelectTable.rows({
                search: 'applied',
                selected: true
            }).count();
            $('#select-all').prop('checked', allRows === selectedRows);
        });
    </script>
    {{-- Modals --}}
    <script>
        function openViewModal(id) {
            // Logic to open view modal
            $('#viewModal').modal('show');

            // Fetch data for the candidate with the given ID
            $.ajax({
                url: `/candidate/edit/${id}`,
                method: 'GET',
                success: function(data) {
                    // Populate the modal fields with the fetched data
                    $('#idCandidateEdit').val(id);
                    $('#inputNameEdit').val(data.name);
                    $('#inputBirthPlaceEdit').val(data.birthplace);
                    jobLevelChoicesEdit.setChoiceByValue(data.job_level);
                    departmentChoicesEdit.setChoiceByValue(data.department);
                    $('#inputBirthDateEdit').val(data.birthdate);
                    $('#inputFirstWorkDayEdit').val(data.first_working_day);
                    $('#inputPictNumberEdit').val(data.candidatepict.pict_number || '');

                },
                error: function() {
                    alert('Error fetching candidate data.');
                }
            });
        }

        function openDeleteModal(id) {
            // Logic to open delete confirmation modal
            alert('Open delete confirmation for ID: ' + id);
        }
    </script>
    {{-- Choices JS Edit --}}
    <script>
        const inputJobLevelEdit = document.getElementById('inputJobLevelEdit');

        const jobLevelChoicesEdit = new Choices(inputJobLevelEdit, {
            searchPlaceholderValue: 'Cari Level Karyawan',
            shouldSort: false,
        });

        jobLevelChoicesEdit
            .setChoices(() =>
                fetch('/joblevel/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputJobLevelEdit').addEventListener('change', function() {
                    const selectedChoice = departmentChoicesEdit.getValue(); // single object
                });

            });
    </script>
    <script>
        const inputDepartmentEdit = document.getElementById('inputDepartmentEdit');

        const departmentChoicesEdit = new Choices(inputDepartmentEdit, {
            searchPlaceholderValue: 'Cari Departemen',
            shouldSort: false,
        });

        departmentChoicesEdit
            .setChoices(() =>
                fetch('/department/choices')
                .then(response => response.json())
            )
            .then(() => {
                document.getElementById('inputDepartmentEdit').addEventListener('change', function() {
                    const selectedChoice = departmentChoicesEdit.getValue(); // single object
                });

            });
    </script>
    {{-- Update Data --}}
    <script>
        function submitCandidateForm() {

            const id = $('#idCandidateEdit').val(); // Ambil ID dari input atau parameter

            const formData = new FormData();
            formData.append('name', $('#inputNameEdit').val());
            formData.append('birthPlace', $('#inputBirthPlaceEdit').val());
            formData.append('jobLevel', $('#inputJobLevelEdit').val());
            formData.append('department', $('#inputDepartmentEdit').val());
            formData.append('birthDate', $('#inputBirthDateEdit').val());
            formData.append('firstWorkDay', $('#inputFirstWorkDayEdit').val());
            formData.append('pictNumber', $('#inputPictNumberEdit').val());

            // Kirim data ke server
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/candidate/update/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert('Kandidat berhasil diperbarui.');
                        $('#viewModal').modal('hide');
                        columSelectTable.ajax.reload(); // Reload the DataTable
                    } else {
                        alert('Gagal memperbarui kandidat. Silakan coba lagi.');
                        console.log(response);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.log(xhr.responseText);
                    console.log(xhr.status);
                    alert('Terjadi kesalahan saat memperbarui kandidat. Silakan coba lagi.');
                }
            });

        }
    </script>

@endsection
