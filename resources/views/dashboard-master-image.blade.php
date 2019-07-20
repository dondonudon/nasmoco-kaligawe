@extends('dashboard-layout')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/filepond-master/filepond.min.css') }}">
@endsection

@php
$area = \App\msArea::all();
@endphp

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Upload Image</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Data Image</h6>
                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="btnNew" style="font-size: 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th width="25%">Area</th>
                                <th width="75%">File</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row mt-2">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-sm btn-block btn-outline-dark" id="btnDelete" disabled>Delete</button>
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-sm btn-block btn-danger" id="btnPreview" disabled>Preview</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardComponent">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="cardTitle">Upload Image</h6>
                        <button type="button" class="btn d-none d-sm-inline-block btn btn-sm btn-outline-danger shadow-sm" style="font-size: 12px;" id="btnClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="cardOption" value="new">
                            <div class="form-group">
                                <label for="inputArea">Pilih Area</label>
                                <div class="row">
                                    <div class="col-lg-10">
                                        <select id="inputArea" name="nama" class="custom-select">
                                            @foreach($area as $a)
                                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-block btn-success" id="btnSet">SET</button>
                                    </div>
                                </div>
                            </div>

                            <input id="uploadImage" type="file" hidden>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/filepond-master/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ asset('vendor/filepond-master/filepond-plugin-image-resize.js') }}"></script>
    <script src="{{ asset('vendor/filepond-master/filepond-plugin-image-crop.js') }}"></script>
    <script src="{{ asset('vendor/filepond-master/filepond-plugin-image-transform.js') }}"></script>
    <script src="{{ asset('vendor/filepond-master/filepond.min.js') }}"></script>
    <script>
        const cardComponent = $('#cardComponent');
        const cardForm = $('#cardForm');
        const cardTitle = $('#cardTitle');
        const cardOption = $('#cardOption');

        const btnNew = $('#btnNew');
        const btnDelete = $('#btnDelete');
        const btnPreview = $('#btnPreview');
        const btnClose = $('#btnClose');
        const btnSet = $('#btnSet');

        const iId = $('#inputId');
        const iNama = $('#inputNama');

        const iArea = $('#inputArea');

        const inputElement = document.getElementById('uploadImage');
        btnSet.click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: cardComponent.offset().top
            }, 1000);
            inputElement.removeAttribute('hidden');
            iArea.attr('disabled', true);
            FilePond.registerPlugin(FilePondPluginImageResize);
            FilePond.registerPlugin(FilePondPluginImageCrop);
            FilePond.registerPlugin(FilePondPluginImageTransform);
            FilePond.create( inputElement );
            FilePond.setOptions({
                allowImageTransform: true,
                allowImageResize: true,
                imageResizeMode: 'cover',
                imageResizeTargetHeight: 700,
                imageResizeTargetWidth: 1200,
                imageTransformOutputMimeType: 'image/jpeg',
                allowMultiple: true,
                allowDrop: true,
                server: {
                    url: '{{ url('dashboard/master/image/add') }}/'+iArea.val(),
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'id_area': '1',
                        }
                    }
                }
            });
        });

        let idArea, namaArea;

        const tables = $('#datatable').DataTable({
            "scrollY": "150px",
            "scrollX": true,
            "scrollCollapse": true,
            // "paging": false,
            "pageLength": 25,
            "bInfo": false,
            "ajax": {
                "method": "GET",
                "url": "{{ url('/dashboard/master/image/list') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                }
            },
            "columns": [
                { "data": "nama" },
                { "data": "file" },
            ],
            "order": [[0,'asc']]
        });

        $('#datatable tbody').on( 'click', 'tr', function () {
            let data = tables.row( this ).data();
            idVote = data.id;
            namaVote = data.nama;
            // console.log(idVote);
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                btnDelete.attr('disabled','true');
                btnPreview.attr('disabled','true');
            } else {
                tables.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                btnDelete.removeAttr('disabled');
                btnPreview.removeAttr('disabled');
            }
        });

        function resetForm() {
            iId.val('');
            iNama.val('');
            tables.ajax.reload();
        }

        $(document).ready(function () {
            btnNew.click(function (e) {
                e.preventDefault();
                resetForm();
                cardComponent.removeClass('d-none');
                cardOption.val('new');
                cardTitle.html('Opsi Vote Baru');
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            btnPreview.click(function (e) {

            });

            btnClose.click(function (e) {
                e.preventDefault();
                tables.ajax.reload();

                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cardComponent.addClass('d-none');
                    FilePond.destroy( inputElement );
                    inputElement.setAttribute('hidden', true);
                    iArea.attr('disabled', false);
                    resetForm();
                });
            });
        })
    </script>
@endsection