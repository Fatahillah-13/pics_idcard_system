@extends('layouts.main')

@section('title', 'Users Management')
@section('breadcrumb-item', 'Settings')

@section('breadcrumb-item-active', 'Users')


@section('css')
    <!-- map-vector css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
@endsection

@section('content')

    {{-- Modal Add User --}}
    <div class="modal fade bd-example-modal-lg" id="addUserModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <select class="form-control @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Recrut" {{ old('role') == 'Recrut' ? 'selected' : '' }}>Recrut</option>
                                <option value="Payroll" {{ old('role') == 'Payroll' ? 'selected' : '' }}>Payroll</option>

                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Confirm Password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="generateBtn" class="btn btn-primary">Tambah User</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit User --}}
    <div class="modal fade bd-example-modal-lg" id="editUserModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('nameEdit') is-invalid @enderror" name="nameEdit"
                                value="{{ old('nameEdit') }}" required autocomplete="nameEdit" autofocus
                                placeholder="Enter name">
                            @error('nameEdit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control @error('emailEdit') is-invalid @enderror" name="emailEdit"
                                value="{{ old('emailEdit') }}" required autocomplete="emailEdit" placeholder="Email Address">
                            @error('emailEdit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <select class="form-control @error('roleEdit') is-invalid @enderror" name="roleEdit" required>
                                <option value="">Pilih Role</option>
                                <option value="Admin" {{ old('roleEdit') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Recrut" {{ old('roleEdit') == 'Recrut' ? 'selected' : '' }}>Recrut</option>
                                <option value="Payroll" {{ old('roleEdit') == 'Payroll' ? 'selected' : '' }}>Payroll</option>

                            </select>
                            @error('roleEdit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control @error('passwordEdit') is-invalid @enderror"
                                name="passwordEdit" required autocomplete="new-passwordEdit" placeholder="Password">
                            @error('passwordEdit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" name="password_confirmationEdit" required
                                autocomplete="new-passwordEdit" placeholder="Confirm Password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="generateEditBtn" class="btn btn-primary">Tambah User</button>
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
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
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
    <!-- [Page Specific JS] start -->
    <script src="{{ URL::asset('build/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/buttons.bootstrap5.min.js') }}"></script>
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
                text: '+ Tambah User',
                action: function(e, dt, node, config) {
                    $('#addUserModal').modal('show');
                }
            }, ],
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
            ajax: '{{ route('users.get') }}',
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return ` <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(${row.id})">Edit</button>` +
                            ` <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})">Delete</button>`;
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

    {{-- Add Users Modal --}}
    <script>
        // Function to handle form submission
        $('#generateBtn').on('click', function() {

            // change role string to integer
            let role = $('select[name="role"]').val();
            if (role === 'Admin') {
                role = 1;
            } else if (role === 'Recrut') {
                role = 2;
            } else if (role === 'Payroll') {
                role = 3;
            } else {
                alert('Please select a valid role.');
                return;
            }
            // Get form data
            let formData = {
                name: $('input[name="name"]').val(),
                email: $('input[name="email"]').val(),
                role: role,
                password: $('input[name="password"]').val(),
                password_confirmation: $('input[name="password_confirmation"]').val()
            };

            // Send AJAX request to store user
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('users.store') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    columSelectTable.ajax.reload();
                    alert('User added successfully!');
                },
                error: function(xhr) {
                    alert('Error adding user: ' + xhr.responseText);
                }
            });
        });
    </script>

    {{-- Edit Users Modal --}}
    <script>
        function openEditModal(userId) {
            $.ajax({
                url: `/users/edit/${userId}`,
                type: 'GET',
                success: function(response) {
                    // Populate the modal with user data
                    $('#editUserModal .modal-body form').find('input[name="nameEdit"]').val(response.name);
                    $('#editUserModal .modal-body form').find('input[name="emailEdit"]').val(response.email);
                    // Set the select input for roleEdit based on response.role (integer or string)
                    let roleValue = '';
                    if (response.role == 1 || response.role === 'Admin') {
                        roleValue = 'Admin';
                    } else if (response.role == 2 || response.role === 'Recrut') {
                        roleValue = 'Recrut';
                    } else if (response.role == 3 || response.role === 'Payroll') {
                        roleValue = 'Payroll';
                    }
                    $('#editUserModal .modal-body form').find('select[name="roleEdit"]').val(roleValue);
                    $('#editUserModal .modal-footer').find('#generateEditBtn').text('Update User');
                    $('#editUserModal').modal('show');

                    // Update the form action to update user
                    $('#editUserModal .modal-footer').off('click', '#generateEditBtn').on('click', '#generateEditBtn',
                        function() {
                            // change role string to integer
                            let roleEdit = $('select[name="roleEdit"]').val();
                            if (roleEdit === 'Admin') {
                                roleEdit = 1;
                            } else if (roleEdit === 'Recrut') {
                                roleEdit = 2;
                            } else if (roleEdit === 'Payroll') {
                                roleEdit = 3;
                            } else {
                                alert('Please select a valid role.');
                                return;
                            }

                            let formData = {
                                name: $('input[name="nameEdit"]').val(),
                                email: $('input[name="emailEdit"]').val(),
                                role: roleEdit,
                                password: $('input[name="passwordEdit"]').val(),
                                password_confirmation: $('input[name="password_confirmationEdit"]').val()
                            };

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: `/users/update/${userId}`,
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    $('#editUserModal').modal('hide');
                                    $('#editUserModal .modal-body form').trigger('reset');
                                    columSelectTable.ajax.reload();
                                    alert('User updated successfully!');
                                },
                                error: function(xhr) {
                                    alert('Error updating user: ' + xhr.responseText);
                                }
                            });
                        });
                },
                error: function(xhr) {
                    alert('Error fetching user data: ' + xhr.responseText);
                }
            });
        }

        // Delete User Function
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: `/users/delete/${userId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        columSelectTable.ajax.reload();
                        alert('User deleted successfully!');
                    },
                    error: function(xhr) {
                        alert('Error deleting user: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
