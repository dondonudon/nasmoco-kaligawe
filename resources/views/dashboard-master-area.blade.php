@extends('dashboard-layout')


@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master Area</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Data Area</h6>
                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="btnNew" style="font-size: 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Nama Area</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row mt-2">
                            <div class="col-xl-10"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnEdit" disabled>Edit</button>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="cardTitle">Area Baru</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="cardOption" value="new">
                            <input type="text" class="d-none" id="inputId" name="id">
                            <div class="form-group">
                                <label for="inputUsername">Nama Area</label>
                                <input type="text" class="form-control" id="inputNama" name="nama" placeholder="Input nama area" autocomplete="off" required>
                            </div>

                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-2 mt-2">
                                    <button type="button" class="btn btn-block btn-outline-dark" id="btnCancel">Cancel</button>
                                </div>
                                <div class="col-xl-2 mt-2">
                                    <button type="submit" class="btn btn-block btn-danger">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        const cardComponent = $('#cardComponent');
        const cardForm = $('#cardForm');
        const cardTitle = $('#cardTitle');
        const cardOption = $('#cardOption');

        const btnNew = $('#btnNew');
        const btnEdit = $('#btnEdit');
        const btnCancel = $('#btnCancel');

        const iId = $('#inputId');
        const iNama = $('#inputNama');

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
                "url": "{{ url('/dashboard/master/area/list') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                }
            },
            "columns": [
                { "data": "nama" },
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
                btnEdit.attr('disabled','true');
            } else {
                tables.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                btnEdit.removeAttr('disabled');
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

            btnEdit.click(function (e) {
                e.preventDefault();
                resetForm();
                cardComponent.removeClass('d-none');
                cardOption.val('edit');
                cardTitle.html('Edit Area');

                iId.val(idVote);
                iNama.val(namaVote);

                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            btnCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cardComponent.addClass('d-none');
                    resetForm();
                });
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                let url;
                if (cardOption.val() == 'new') {
                    url = "{{ url('dashboard/master/area/add') }}";
                } else {
                    url = "{{ url('dashboard/master/area/edit') }}";
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: url,
                    method: "post",
                    data: $(this).serialize(),
                    success: function(result) {
                        // console.log(result);
                        var data = JSON.parse(result);
                        if (data.status == 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Data tersimpan',
                                onClose: function() {
                                    $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                        cardComponent.addClass('d-none');
                                        resetForm();
                                        tables.ajax.reload();
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'info',
                                title: 'Gagal',
                                text: data.reason,
                            });
                        }
                    }
                });
            })
        })
    </script>
@endsection