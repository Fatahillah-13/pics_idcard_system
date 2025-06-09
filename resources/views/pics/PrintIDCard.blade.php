@extends('layouts.main')

@section('title', 'Tambah NIK + Cetak ID Card')
@section('breadcrumb-item', 'PICS Pegawai Baru')

@section('breadcrumb-item-active', 'Tambah NIK + Cetak ID Card')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/autoFill.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/keyTable.bootstrap5.min.css') }}">
@endsection

@section('content')
    {{-- Modal --}}
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
                    <button type="button" class="btn btn-primary">Simpan NIK</button>
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
                                <th></th>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Departemen</th>
                                <th>TTL</th>
                                <th>Tanggal Masuk</th>
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
    {{-- <script src="{{ URL::asset('build/js/plugins/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/autoFill.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/keyTable.bootstrap5.min.js') }}"></script> --}}
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
        $('#colum-select').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    text: '+ Tambah NIK',
                    action: function(e, dt, node, config) {
                        const selectedData = dt.rows({
                            selected: true
                        }).data();
                        let selectedIds = [];

                        for (let i = 0; i < selectedData.length; i++) {
                            selectedIds.push(selectedData[i].id); // assuming your row has an 'id' field
                        }

                        // Open the modal to add NIK for selected candidates
                        $('#addCandidateNumberModal').modal('show');
                        // Fill the modal table body manually without DataTable
                        let tbody = $('#addCandidateNumberTable tbody');
                        tbody.empty();
                        for (let i = 0; i < selectedData.length; i++) {
                            let row = selectedData[i];
                            let birthdate = row.birthdate ? row.birthdate.split('-') : [];
                            let formattedDate = birthdate.length === 3 ?
                                `${birthdate[2]}-${birthdate[1]}-${birthdate[0]}` : row.birthdate;
                            let ttl = `${row.birthplace}, ${formattedDate}`;
                            let firstWorkingDay = row.first_working_day ? row.first_working_day.split('-') : [];
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
                        let maxEmployeeID = 0;
                        for (let i = 0; i < selectedData.length; i++) {
                            if (selectedData[i].employee_id && parseInt(selectedData[i].employee_id) > maxEmployeeID) {
                                maxEmployeeID = parseInt(selectedData[i].employee_id);
                            }
                        }
                        $('#employeeID').val(maxEmployeeID + 1);
                        
                    }
                },
                {
                    text: 'Cetak ID Card',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {
                        alert('Button 2 clicked on');
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
                    data: 'first_working_day',
                    render: function(data, type, row) {
                        if (!data) return '';
                        let date = data.split('-');
                        return date.length === 3 ? `${date[2]}-${date[1]}-${date[0]}` : data;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<button type="button" class="btn btn-primary btn-sm" onclick="openViewModal(${row.id})">View</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(${row.id})">Delete</button>`;
                    }
                }
            ]
        });
    </script>
    <script>
        function openViewModal(id) {
            // Logic to open edit modal and populate data
            alert('Open edit modal for ID: ' + id);
        }

        function openDeleteModal(id) {
            // Logic to open delete confirmation modal
            alert('Open delete confirmation for ID: ' + id);
        }
    </script>
@endsection
