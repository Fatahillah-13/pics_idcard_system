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
                        <select class="form-control" name="inputJobLevel" id="inputJobLevel">
                            <option value="">Pilih Level Karyawan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputDepartment">Pilih Departemen</label>
                        <select class="form-control" name="inputDepartment" id="inputDepartment">
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
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".web">Web
                                    Designer</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".graphic">Graphic
                                    Designer</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".animation">Animation
                                    Designer</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".uiux">UI/UX
                                    Designer</button>
                                <button class="btn my-1 btn-sm btn-light-primary" data-filter=".product">Product
                                    Designer</button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <ul class="list-inline d-flex align-items-center ms-auto my-1">
                                <li class="list-inline-item align-bottom">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLive">+ Tambah Template</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item web">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-1.jpg') }}">
                                <img class="img-fluid" src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-1.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-1.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item graphic">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-2.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-2.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-2.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item animation">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-3.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-3.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-3.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item uiux">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-4.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-4.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-4.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item product">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-5.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-5.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-5.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item web">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-6.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-6.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-1.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item graphic">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-7.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-7.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-2.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item animation">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-8.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-8.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-3.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item uiux">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-9.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-9.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-4.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item product">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-10.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-10.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-5.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item web">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-11.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-11.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-1.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item graphic">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-12.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-12.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-2.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item animation">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-13.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-13.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-3.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item uiux">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-14.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-14.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-4.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item product">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-15.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-15.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-5.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-md-4 col-sm-6 element-item web">
                            <a class="card-gallery" data-fslightbox="gallery"
                                href="{{ URL::asset('build/images/gallery-grid/img-grd-gal-16.jpg') }}">
                                <img class="img-fluid"
                                    src="{{ URL::asset('build/images/gallery-grid/img-grd-gal-16.jpg') }}"
                                    alt="Card image" />
                                <div class="gallery-hover-data card-body">
                                    <div class="position-relative text-end">
                                        <div class="form-check prod-likes d-inline-block">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="chat-avtar">
                                                <img class="rounded-circle img-fluid wid-30"
                                                    src="{{ URL::asset('build/images/user/avatar-1.jpg') }}"
                                                    alt="User image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 mx-2 text-white">
                                            <p class="mb-0 text-truncate w-100">Alexander</p>
                                            <span class="mb-0 text-sm text-truncate w-100">Photographer artist</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
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
            const jobLevel = document.getElementById('inputJobLevel').value;
            const department = document.getElementById('inputDepartment').value;
            const ctpat = document.getElementById('CTPATcheckbox').checked ? 1 : 0;

            if (!fileInput.files.length) {
                alert('File harus dipilih.');
                return;
            }
            if (!jobLevel) {
                alert('Level karyawan harus dipilih.');
                return;
            }
            if (!department) {
                alert('Departemen harus dipilih.');
                return;
            }

            const formData = new FormData();
            formData.append('image_path', fileInput.files[0]); // 'image_path' must match controller
            formData.append('job_level', jobLevel);
            formData.append('department', department);
            formData.append('ctpat', ctpat);

            $.ajax({
                url: '/card-template/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function(data) {
                    alert(data.success ? 'Template berhasil diupload!' : (data.message ||
                        'Gagal upload template.'));
                    if (data.success) location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat upload.');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
