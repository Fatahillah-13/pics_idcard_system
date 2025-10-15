@extends('layouts.main')

@section('title', 'ID Card Templates')
@section('breadcrumb-item', 'Settings')

@section('breadcrumb-item-active', 'ID Card Templates')

@section('css')
@endsection

@section('content')
    <!-- [ Input Template Modal ] start -->
    <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Input Template ID Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="demo-input-file" class="form-label">File</label>
                        <input class="form-control" type="file" id="input-file">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputJobLevel">Pilih Level</label>
                        <select class="form-control" name="inputJobLevel" id="inputJobLevel" multiple>
                            <option value="">Pilih Level Karyawan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputDepartment">Pilih Departemen</label>
                        <select class="form-control" name="inputDepartment" id="inputDepartment" multiple>
                            <option value="">Pilih Departemen</option>
                        </select>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="CTPATcheckbox">
                        <label class="form-check-label" for="flexCheckDefault"> CTPAT </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="saveTemplate" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Input Template Modal ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-auto">
                            <div id="filters" class="btn-filter btns-gallery">
                                <button class="btn my-1 btn-sm btn-light-primary active" data-filter="*">Show
                                    all</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".ctpat">CTPAT</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".nonctpat">Non-CTPAT</button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <ul class="list-inline d-flex align-items-center ms-auto my-1">
                                <li class="list-inline-item align-bottom">
                                    <a href="/card-template/add" class="btn btn-success">+ Tambah Template</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">
                        @foreach ($templates as $template)
                            <div
                                class="col-xxl-6 col-xl-4 col-md-3 col-sm-2 element-item {{ $template->department }} {{ $template->joblevel }} 
                                {{ $template->ctpat ? 'ctpat' : 'nonctpat' }}">
                                <a class="card-gallery" data-fslightbox="gallery" href="{{ asset($template->image_path) }}">
                                    <img class="img-fluid" src="{{ asset($template->image_path) }}" alt="Card image" />
                                    <div class="gallery-hover-data card-body">
                                        <div class="position-relative text-end">
                                            <div class="form-check prod-likes d-inline-block">
                                                <i data-feather="trash" class="prod-likes-icon"
                                                    onclick="deleteTemplate()"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 mx-2 text-white">
                                                <p class="mb-0 text-truncate w-100">{{ $template->id }} -
                                                    {{ $template->joblevel }}</p>
                                                <span class="mb-0 text-sm text-truncate w-100">{{ $template->department }}
                                                    {{ $template->ctpat ? ' - CTPAT' : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/choices.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/plugins/index.js') }}"></script>
    {{-- choices js --}}
    <script>
        const inputDepartment = document.getElementById('inputDepartment');

        const departmentChoices = new Choices(inputDepartment, {
            removeItemButton: true, // Enables the remove (×) button
            searchPlaceholderValue: 'Cari Departemen',
            shouldSort: false,
            duplicateItemsAllowed: false,
            maxItemCount: -1, // No limit on selected items
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
    <script>
        const inputJobLevel = document.getElementById('inputJobLevel');

        const jobLevelChoices = new Choices(inputJobLevel, {
            removeItemButton: true, // Enables the remove (×) button
            searchPlaceholderValue: 'Cari Job Level',
            shouldSort: false,
            duplicateItemsAllowed: false,
            maxItemCount: -1, // No limit on selected items
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
    {{-- isotope js --}}
    <script>
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                var grid = new Isotope('.grid', {
                    itemSelector: '.element-item',
                    layoutMode: 'masonry',
                    masonry: {
                        columnWidth: 4
                    }
                });
                var filterFns = {
                    numberGreaterThan50: function(itemElem) {
                        var number = itemElem.querySelector('.number').textContent;
                        return parseInt(number, 10) > 50;
                    },
                    ium: function(itemElem) {
                        var name = itemElem.querySelector('.name').textContent;
                        return name.match(/ium$/);
                    }
                };

                var tc = document.querySelectorAll('#filters button');
                for (var t = 0; t < tc.length; t++) {
                    var c = tc[t];
                    c.addEventListener('click', function(event) {
                        event.stopPropagation();
                        var targetElement = event.target;
                        var filterValue = targetElement.getAttribute('data-filter');

                        filterValue = filterFns[filterValue] || filterValue;
                        grid.arrange({
                            filter: filterValue
                        });
                    });
                }

                var buttonGroups = document.querySelectorAll('.btn-filter .btn');
                for (var i = 0, len = buttonGroups.length; i < len; i++) {
                    var buttonGroup = buttonGroups[i];
                    radioButtonGroup(buttonGroup);
                }

                function radioButtonGroup(buttonGroup) {
                    buttonGroup.addEventListener('click', function(event) {
                        document.querySelector('.btn-filter .btn.active').classList.remove('active');
                        event.target.classList.add('active');
                    });
                }
            });
        })();
    </script>
    {{-- Upload File & Data --}}
    <script>
        document.getElementById('saveTemplate').addEventListener('click', function() {
            const fileInput = document.getElementById('input-file');
            // Get selected options as array of values
            const jobLevelSelect = document.getElementById('inputJobLevel');
            const departmentSelect = document.getElementById('inputDepartment');
            const jobLevels = Array.from(jobLevelSelect.selectedOptions).map(opt => opt.value).filter(v => v);
            const departments = Array.from(departmentSelect.selectedOptions).map(opt => opt.value).filter(v => v);
            const ctpat = document.getElementById('CTPATcheckbox').checked ? 1 : 0;

            if (!fileInput.files.length) {
                alert('File harus dipilih.');
                return;
            }
            if (!jobLevels.length) {
                alert('Level karyawan harus dipilih.');
                return;
            }
            if (!departments.length) {
                alert('Departemen harus dipilih.');
                return;
            }

            const formData = new FormData();
            formData.append('image_path', fileInput.files[0]); // 'image_path' must match controller
            // Append each value in the array
            jobLevels.forEach(level => formData.append('job_level[]', level));
            departments.forEach(dep => formData.append('department[]', dep));
            formData.append('ctpat', ctpat);

            // $.ajax({
            //     url: '/card-template/upload',
            //     type: 'POST',
            //     data: formData,
            //     processData: false,
            //     contentType: false,
            //     headers: {
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
            //             'content')
            //     },
            //     success: function(data) {
            //         alert(data.success ? 'Template berhasil diupload!' : (data.message ||
            //             'Gagal upload template.'));
            //         if (data.success) location.reload();
            //     },
            //     error: function(xhr) {
            //         alert('Terjadi kesalahan saat upload.');
            //         console.error(xhr.responseText);
            //     }
            // });
        });
    </script>
    {{-- Delete Function --}}
    <script>
        function deleteTemplate() {
            if (confirm('Apakah Anda yakin ingin menghapus template ini?')) {
                // Get the template ID from the data attribute
                const templateId = event.target.closest('.element-item').querySelector('p.mb-0.text-truncate').textContent
                    .split(' - ')[0].trim();

                $.ajax({
                    url: `/card-template/delete/${templateId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    success: function(data) {
                        alert(data.success ? 'Template berhasil dihapus!' : (data.message ||
                            'Gagal menghapus template.'));
                        if (data.success) location.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus template.');
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
