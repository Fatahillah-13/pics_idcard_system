@extends('layouts.main')

@section('title', 'Tambah NIK + Cetak ID Card')
@section('breadcrumb-item', 'PICS Pegawai Baru')

@section('breadcrumb-item-active', 'Tambah NIK + Cetak ID Card')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/autoFill.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/keyTable.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/uppy.min.css') }}">
    <style>
        .table-scrollable-down {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <style>
        .uppy-Dashboard-inner {
            max-height: 350px;
        }
    </style>
@endsection

@section('content')
    {{-- Modal Add NIK --}}
    <div class="modal fade bd-example-modal-lg" id="addCandidateNumberModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah NIK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 mb-3">
                        <div class="col-md-4">
                            <div class="mb-0">
                                <label class="form-label">Prefix</label>
                                <input type="number" class="form-control" id="prefix" placeholder="Text" readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-0">
                                <label class="form-label">Nomor Karyawan</label>
                                <input type="number" class="form-control" id="employeeID" placeholder="Text">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover" id="addCandidateNumberTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>TTL</th>
                                        <th>Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="generateBtn" class="btn btn-primary">Simpan NIK</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Print --}}
    <div class="modal fade bd-example-modal-lg" id="printIDcardModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah NIK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-scrollable-down">
                        <table class="table table-hover" id="printIDcardTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        <div class="form-check">
                                            <label class="form-check-label" for="ctpatCheckbox">
                                                CTPAT
                                            </label>
                                            <input class="form-check-input" type="checkbox" id="ctpatCheckboxAll">
                                        </div>
                                    </th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jabatan (Departemen)</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="generateIDCardBtn" class="btn btn-primary">Print ID Card</button>
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
                        <div class="col-md-4">
                            <div class="pc-uppy" id="pc-uppy-1"> </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label" for="inputNIK">NIK ID CARD</label>
                                <input type="text" class="form-control" name="inputNIK" id="inputNIK"
                                    placeholder="Nomor Induk Karyawan" required />
                            </div>
                            <div class="row">
                                <input type="number" class="form-control" name="id" id="idCandidate" hidden />
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="inputName">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="inputName" id="inputName"
                                        placeholder="Nama Lengkap" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="inputBirthPlace">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="inputBirthPlace"
                                        id="inputBirthPlace" placeholder="Tempat Lahir" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="inputJobLevel">Level Karyawan</label>
                                    <select class="form-control" name="inputJobLevel" id="inputJobLevel">
                                        <option value="">Pilih Level Karyawan</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="inputDepartment">Departemen</label>
                                    <select class="form-control" name="inputDepartment" id="inputDepartment">
                                        <option value="">Pilih Departemen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="form-label" for="inputBirthDate">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="inputBirthDate" id="inputBirthDate"
                                        required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label" for="inputFirstWorkDay">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="inputFirstWorkDay"
                                        id="inputFirstWorkDay" required />
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label" for="inputPictNumber">No. Foto</label>
                                    <input type="number" class="form-control" name="inputPictNumber"
                                        id="inputPictNumber" />
                                </div>
                            </div>
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
                                <th>NIK</th>
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
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.select.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/uppy.min.js') }}"></script>
    {{-- Choices JS --}}
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
                    text: '+ Tambah NIK',
                    action: function(e, dt, node, config) {
                        const selectedData = dt.rows({
                            selected: true
                        }).data();
                        let selectedIds = [];

                        for (let i = 0; i < selectedData.length; i++) {
                            selectedIds.push(selectedData[i].id); // assuming your row has an 'id' field
                        }

                        // alert when month & year of first_working_day is different
                        if (selectedData.length > 1) {
                            let firstDate = selectedData[0].first_working_day ? selectedData[0]
                                .first_working_day.split('-') : [];
                            let firstMonth = firstDate.length === 3 ? firstDate[1] : null;
                            let firstYear = firstDate.length === 3 ? firstDate[0] : null;
                            for (let i = 1; i < selectedData.length; i++) {
                                let currDate = selectedData[i].first_working_day ? selectedData[i]
                                    .first_working_day.split('-') : [];
                                let currMonth = currDate.length === 3 ? currDate[1] : null;
                                let currYear = currDate.length === 3 ? currDate[0] : null;
                                if (currMonth !== firstMonth || currYear !== firstYear) {
                                    alert(
                                        'Perhatian: Bulan & tahun tanggal masuk berbeda untuk beberapa kandidat.'
                                    );
                                    $('#addCandidateNumberModal').modal('hide');
                                    break;
                                }
                            }
                        }

                        // Open the modal to add NIK for selected candidates
                        $('#addCandidateNumberModal').modal('show');
                        // Fill the modal table body manually without DataTable
                        let tbody = $('#addCandidateNumberTable tbody');
                        tbody.empty();

                        // Loop through selected data and append rows
                        for (let i = 0; i < selectedData.length; i++) {
                            let row = selectedData[i];
                            let birthdate = row.birthdate ? row.birthdate.split('-') : [];
                            let formattedDate = birthdate.length === 3 ?
                                `${birthdate[2]}-${birthdate[1]}-${birthdate[0]}` : row.birthdate;
                            let ttl = `${row.birthplace}, ${formattedDate}`;
                            let firstWorkingDay = row.first_working_day ? row.first_working_day.split('-') :
                                [];
                            let formattedFirstWorkingDay = firstWorkingDay.length === 3 ?
                                `${firstWorkingDay[2]}-${firstWorkingDay[1]}-${firstWorkingDay[0]}` : row
                                .first_working_day;
                            tbody.append(`
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${row.employee_id || ''}</td>
                                    <td>${row.name || ''}</td>
                                    <td>${ttl}</td>
                                    <td>${formattedFirstWorkingDay || ''}</td>
                                </tr>
                            `);
                        }

                        // Set the prefix based on first_working_day
                        let prefix = '';
                        if (selectedData.length > 0 && selectedData[0].first_working_day) {
                            let parts = selectedData[0].first_working_day.split('-');
                            if (parts.length === 3) {
                                // parts[0] = yyyy, parts[1] = mm
                                prefix = parts[0].slice(2, 4) + parts[1] + 0;
                            }
                        }
                        $('#prefix').val(prefix);

                        // set employeeID input based on database
                        let employeeIDInput = $('#employeeID');
                        let firstWorkingDay = selectedData.length > 0 ? selectedData[0].first_working_day :
                            null;

                        if (firstWorkingDay) {
                            let parts = firstWorkingDay.split('-');
                            if (parts.length === 3) {
                                let year = parts[0];
                                let month = parts[1];
                                // AJAX request to get max employee_id for same month & year
                                $.ajax({
                                    url: '{{ route('candidate.maxEmployeeID') }}',
                                    method: 'GET',
                                    data: {
                                        year: year,
                                        month: month
                                    },
                                    success: function(response) {
                                        // response.max_employee_id should be the max employee_id or 0 if none
                                        // Ambil setelah digit ke-5, lalu tambah 1
                                        let maxID = response.max_employee_id ? response
                                            .max_employee_id.toString() : '';
                                        let nextID = '';
                                        if (maxID.length > 5) {
                                            let lastDigits = maxID.substring(5);
                                            nextID = (parseInt(lastDigits, 10) || 0) + 1;
                                        } else {
                                            nextID = 1;
                                        }
                                        employeeIDInput.val(nextID);
                                    },
                                    error: function() {
                                        employeeIDInput.val('');
                                    }
                                });
                            }
                        }

                        // Handle the generate button click
                        $('#generateBtn').on('click', function() {
                            let employeeID = $('#employeeID').val();
                            let EmployeeNIK = $('#prefix').val() + employeeID;
                            if (!employeeID) {
                                alert('Mohon masukkan Nomor Karyawan.');
                                return;
                            }

                            // Extract selected rows into plain array
                            let rawData = columSelectTable.rows({
                                selected: true
                            }).data().toArray();

                            // Create new array with updated employee_id
                            // let selectedData = rawData.map((item, index) => ({
                            //     id: item.id,
                            //     employee_id: $('#prefix').val() + employeeID,
                            // }));

                            let startID = parseInt(employeeID, 10);

                            let selectedData = rawData.map((item, index) => {
                                let newID = startID + index;
                                let paddedID = newID.toString().padStart(employeeID.length,
                                    '0');
                                return {
                                    id: item.id,
                                    employee_id: $('#prefix').val() + paddedID
                                };
                            });


                            $.ajax({
                                url: '{{ route('candidate.updateEmployeeID') }}',
                                method: 'POST',
                                data: JSON.stringify({
                                    _token: '{{ csrf_token() }}',
                                    candidates: selectedData,
                                }),
                                contentType: 'application/json',
                                success: function(response) {
                                    if (response.success) {
                                        columSelectTable.ajax.reload();
                                    } else {
                                        alert(
                                            'Gagal menyimpan NIK. Silakan coba lagi.'
                                        );
                                    }
                                },
                                error: function(xhr) {
                                    if (xhr.responseJSON) {
                                        let message = xhr.responseJSON.message;
                                        let duplicates = xhr.responseJSON.duplicates;

                                        // tampilkan pesan
                                        alert(message);

                                    } else {
                                        alert("Terjadi error tak terduga.");
                                    }
                                }
                            });

                            $('#addCandidateNumberModal').modal('hide');
                            columSelectTable.ajax.reload();
                        });
                    }
                },
                {
                    // Button to print ID Card
                    text: 'Cetak ID Card',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {

                        const selectedData = dt.rows({
                            selected: true
                        }).data();
                        let selectedIds = [];

                        for (let i = 0; i < selectedData.length; i++) {
                            selectedIds.push(selectedData[i].id); // assuming your row has an 'id' field
                        }

                        $('#printIDcardModal').modal('show');
                        let tbody = $('#printIDcardTable tbody');
                        tbody.empty();

                        // Loop through selected data and append rows
                        for (let i = 0; i < selectedData.length; i++) {
                            let row = selectedData[i];
                            let printName = '';
                            if (row.name) {
                                let words = row.name.trim().split(/\s+/);
                                if (words.length >= 3) {
                                    printName = words[0].toUpperCase() + ' ' + words[1].toUpperCase();
                                    for (let i = 2; i < words.length; i++) {
                                        printName += ' ' + words[i][0].toUpperCase() + '.';
                                    }
                                } else {
                                    printName = row.name.toUpperCase();
                                }
                            }
                            let birthdate = row.birthdate ? row.birthdate.split('-') : [];
                            let formattedDate = birthdate.length === 3 ?
                                `${birthdate[2]}-${birthdate[1]}-${birthdate[0]}` : row.birthdate;
                            let ttl = `${row.birthplace}, ${formattedDate}`;
                            let firstWorkingDay = row.first_working_day ? row.first_working_day.split('-') :
                                [];
                            let formattedFirstWorkingDay = firstWorkingDay.length === 3 ?
                                `${firstWorkingDay[2]}-${firstWorkingDay[1]}-${firstWorkingDay[0]}` : row
                                .first_working_day;
                            tbody.append(`
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ctpatCheckbox${row.id}">
                                        </div>
                                    <td>
                                    ${row.candidatepict && row.candidatepict.pict_name
                                        ? `<img src="/storage/${row.candidatepict.pict_name}" alt="Photo" width="60" height="80" style="object-fit:cover; border-radius:4px;">`
                                        : '<span class="text-muted">-</span>'}
                                    </td>
                                    <td>${row.employee_id || ''}</td>
                                    <td>${printName || ''}</td>
                                    <td>${row.job_level || ''} (${row.department || ''})</td>
                                    <td>${formattedFirstWorkingDay || ''}</td>
                                </tr>
                            `);
                        }

                        $('#ctpatCheckboxAll').on('click', function() {
                            let isChecked = this.checked;
                            $('#printIDcardTable tbody input[type="checkbox"]').each(function() {
                                this.checked = isChecked;
                            });
                        });

                        $('#generateIDCardBtn').on('click', function() {

                            let formData = [];
                            // Ambil data dari tabel
                            $('#printIDcardTable tbody tr').each(function() {
                                let row = $(this);
                                let checkbox = row.find('input[type="checkbox"]');
                                let employeeID = row.find('td:nth-child(4)').text().trim();
                                let name = row.find('td:nth-child(5)').text().trim();
                                let firstWorkingDay = row.find('td:nth-child(7)').text()
                                    .trim();
                                formData.push({
                                    employee_id: employeeID,
                                    name: name,
                                    ctpat: checkbox.is(':checked') ? 1 : 0,
                                });
                            });

                            if (formData.length === 0) {
                                alert('Tidak ada kandidat yang dipilih untuk dicetak ID Card-nya.');
                                return;
                            }

                            // check type data employee_id
                            for (let i = 0; i < formData.length; i++) {
                                if (typeof formData[i].employee_id !== 'string' || formData[i]
                                    .employee_id.trim() === '') {
                                    alert('Mohon pastikan semua kandidat memiliki NIK yang valid.');
                                    return;
                                }
                            }

                            // AJAX request to print ID Cards
                            $.ajax({
                                url: '{{ route('candidate.printIDCard') }}',
                                method: 'POST',
                                data: JSON.stringify({
                                    _token: '{{ csrf_token() }}',
                                    candidates: formData,
                                }),
                                contentType: 'application/json',
                                success: function(response) {
                                    if (response.success) {
                                        // console.log(response.generated_pdf);
                                        window.open(response.generated_pdf);
                                        alert('ID Card berhasil dicetak.');
                                        $('#printIDcardModal').modal('hide');
                                        columSelectTable.ajax.reload();
                                    } else {
                                        alert(
                                            'Gagal mencetak ID Card. Silakan coba lagi.'
                                        );
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error:', error);
                                    console.log(xhr.responseText);
                                    console.log(xhr.status);
                                    alert(
                                        'Terjadi kesalahan saat mencetak ID Card. Silakan coba lagi.'
                                    );
                                }
                            });

                            // Close modal after submission & clear table
                            $('#printIDcardTable tbody').empty();
                            $('#printIDcardModal').modal('hide');
                            $('#ctpatCheckboxAll').prop('checked', false);
                        });
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
                },
                {
                    text: 'Export Data',
                    className: 'btn btn-secondary',
                    action: function(e, dt, node, config) {
                        const selectedData = dt.rows({
                            selected: true
                        }).data();
                        const selectedIds = selectedData.toArray().map(row => row.id);

                        if (selectedIds.length === 0) {
                            alert('Tidak ada kandidat yang dipilih untuk diexport.');
                            return;
                        }

                        if (!confirm('Apakah Anda yakin ingin mengekspor data kandidat terpilih?')) {
                            return;
                        }

                        $.ajax({
                            url: '{{ route('candidate.export') }}',
                            method: 'POST',
                            data: JSON.stringify({
                                _token: '{{ csrf_token() }}',
                                candidate_ids: selectedIds,
                            }),
                            contentType: 'application/json',
                            success: function(response) {
                                if (response.success && response.file_url) {
                                    window.location.href = response.file_url;
                                } else {
                                    alert('Gagal mengekspor data kandidat. Silakan coba lagi.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                alert('Terjadi kesalahan pada server. Coba lagi nanti.');
                            }
                        });
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
            ajax: '{{ route('candidate.index') }}',
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
                    data: 'employee_id'
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
    {{-- Uppy JS --}}
    <script type="module">
        import {
            Uppy,
            Dashboard,
            Webcam,
            Tus,
            ThumbnailGenerator,
            ImageEditor
        } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs';

        const uppy1 = new Uppy({
                debug: true,
                autoProceed: false
            })
            .use(Dashboard, {
                target: '#pc-uppy-1',
                inline: true,
                showProgressDetails: true,
                hideUploadButton: true,
                videoConstraints: {
                    width: {
                        min: 640,
                        ideal: 1920,
                        max: 1920
                    },
                    height: {
                        min: 360,
                        ideal: 1080,
                        max: 1080
                    },
                },
            })
            .use(Webcam, {
                target: Dashboard,
                showVideoSourceDropdown: true
            })
            .use(ImageEditor, {
                target: Dashboard, // attach editor into the Dashboard UI
                quality: 0.8,
                cropperOptions: {
                    viewMode: 1,
                    aspectRatio: NaN, // NaN = free crop; set number for locked aspect ratio
                    background: false,
                    autoCropArea: 1
                },
                // actions — toggle what the editor UI shows
                actions: {
                    revert: true,
                    rotate: true,
                    granularRotate: true,
                    flip: true,
                    zoomIn: true,
                    zoomOut: true,
                    cropSquare: true,
                    cropWidescreen: true,
                    cropWidescreenVertical: true
                }
            })
            .use(Tus, {
                endpoint: 'https://tusd.tusdemo.net/files/'
            })
            .use(ThumbnailGenerator);

        // Bikin global biar bisa dipakai di script biasa
        window.uppy1 = uppy1;
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
                    $('#idCandidate').val(id);
                    $('#inputNIK').val(data.employee_id);
                    $('#inputName').val(data.name);
                    $('#inputBirthPlace').val(data.birthplace);
                    jobLevelChoices.setChoiceByValue(data.job_level);
                    departmentChoices.setChoiceByValue(data.department);
                    $('#inputBirthDate').val(data.birthdate);
                    $('#inputFirstWorkDay').val(data.first_working_day);
                    $('#inputPictNumber').val(data.candidatepict.pict_number || '');

                    // ===== Add old picture to uppy interface =====
                    if (data.candidatepict && data.candidatepict.image_url) {
                        fetch(data.candidatepict.image_url)
                            .then(res => res.blob())
                            .then(blob => {
                                uppy1.addFile({
                                    name: data.candidatepict
                                        .image_url, // File name
                                    type: blob.type,
                                    data: blob,
                                    source: 'server',
                                    isRemote: false
                                });
                            });
                    }

                },
                error: function() {
                    alert('Error fetching candidate data.');
                }
            });

            // If modal closed,reset Uppy instance
            $('#viewModal').on('hidden.bs.modal', function() {
                uppy1.cancelAll();
            });

        }

        function openDeleteModal(id) {
            // Logic to open delete confirmation modal
            alert('Open delete confirmation for ID: ' + id);
        }
    </script>
    {{-- Submit Data --}}
    <script>
        function submitCandidateForm() {

            const id = $('#idCandidate').val(); // Ambil ID dari input atau parameter

            const formData = new FormData();
            formData.append('employee_id', $('#inputNIK').val());
            formData.append('name', $('#inputName').val());
            formData.append('birthPlace', $('#inputBirthPlace').val());
            formData.append('jobLevel', $('#inputJobLevel').val());
            formData.append('department', $('#inputDepartment').val());
            formData.append('birthDate', $('#inputBirthDate').val());
            formData.append('firstWorkDay', $('#inputFirstWorkDay').val());
            formData.append('pictNumber', $('#inputPictNumber').val());

            const uppyFiles = uppy1.getFiles();
            if (uppyFiles.length > 0) {
                const file = uppyFiles[0].data;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64Data = e.target.result; // sudah dalam format data:image/png;base64,...

                    formData.append('imagePath', base64Data);

                    // Debug form data
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ':', pair[1]);
                    }

                    // Kirim AJAX setelah base64 siap
                    $.ajax({
                        url: `/candidate/update/${id}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Data berhasil diperbarui!');
                            $('#viewModal').modal('hide');
                            $('#colum-select').DataTable().ajax.reload(null, false);
                        },
                        error: function(err) {
                            alert('Gagal memperbarui data.');
                            console.log(err.responseJSON);
                        }
                    });
                };
                reader.readAsDataURL(file); // ini yang mengubah ke base64
            } else {
                // Kalau tidak ada file, langsung kirim form
                $.ajax({
                    url: `/candidate/update/${id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        alert('Data berhasil diperbarui!');
                        $('#viewModal').modal('hide');
                        $('#colum-select').DataTable().ajax.reload(null, false);
                    },
                    error: function(err) {
                        alert('Gagal memperbarui data.');
                        console.log(err.responseJSON);
                    }
                });
            }
        }
    </script>
@endsection
