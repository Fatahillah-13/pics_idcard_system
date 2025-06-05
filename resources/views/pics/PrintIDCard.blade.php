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
                <div class="modal-body"> ... </div>
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
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Departemen</th>
                                <th>Tempat Lahir</th>
                                <th>Tgl. Lahir</th>
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

                        // Optional: format as a list or plain text
                        let content = selectedIds.length ?
                            `<p>Selected IDs:</p><ul>${selectedIds.map(id => `<li>${id}</li>`).join('')}</ul>` :
                            '<p>No rows selected.</p>';

                        // Set content inside modal body
                        $('#addCandidateNumberModal .modal-body').html(content);
                        $('#addCandidateNumberModal').modal('show');
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
                    data: 'name'
                },
                {
                    data: 'job_level'
                },
                {
                    data: 'department'
                },
                {
                    data: 'birthplace'
                },
                {
                    data: 'birthdate'
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
