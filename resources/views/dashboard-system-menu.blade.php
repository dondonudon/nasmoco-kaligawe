@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">System Utility Menu</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Data Group Menu</h6>
                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="btnNew" style="font-size: 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Nama Menu</th>
                                <th>Group</th>
                                <th>Url</th>
                                <th>View Name</th>
                                <th>Order</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                {{--                                <button class="btn btn-block btn-outline-danger" id="btnDisable" disabled>Disable</button>--}}
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnEdit" disabled>Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardData">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">New Group</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
                            <div class="form-group">
                                <label for="inputGroup">Nama Group</label>
                                <select class="form-control" id="inputGroup" name="id_group"></select>
                            </div>
                            <div class="form-group">
                                <label for="inputMenu">Nama Menu</label>
                                <input type="text" class="form-control" id="inputMenu" name="nama" placeholder="Nama Menu" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputUrl">Url</label>
                                <input type="text" class="form-control" id="inputUrl" name="url" placeholder="Url" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputViewName">Url</label>
                                <input type="text" class="form-control" id="inputViewName" name="view_name" placeholder="View Name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputOrder">Order</label>
                                <input type="number" class="form-control" id="inputOrder" name="order" placeholder="Order" autocomplete="off" required>
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
        const iGroup = $('#inputGroup');
        const iNama = $('#inputMenu');
        const iUrl = $('#inputUrl');
        const iViewName = $('#inputViewName');
        const iOrder = $('#inputOrder');

        const cardComponent = $('#cardData');
        const cardForm = $('#cardForm');
        const cardTitle = $('#judulCard');
        const optionData = $('#option');

        const buttonNew = $('#btnNew');
        const buttonDisable = $('#btnDisable');
        const buttonEdit = $('#btnEdit');
        const buttonCancel = $('#btnCancel');

        var idMenu, idGroup, htmlGroup, menuName, url, viewName, order;

        function resetForm() {
            iNama.val('');
            iUrl.val('');
            iViewName.val('');
            iOrder.val('');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: "{{ url('/dashboard/system/menu/list/group') }}",
                method: "get",
                success: function(result) {
                    let data = JSON.parse(result);
                    data.forEach(function(v,i,a) {
                        htmlGroup += '<option value="'+v.id+'">'+v.nama+'</option>';
                    });
                    iGroup.html(htmlGroup);
                }
            });
            var tables = $('#datatable').DataTable({
                "scrollY": "150px",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "bInfo": false,
                "searching": false,
                "ajax": {
                    "method": "GET",
                    "url": "{{ url('/dashboard/system/menu/list') }}",
                    "header": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                "columns": [
                    { "data": "nama" },
                    { "data": "nama_group" },
                    { "data": "url" },
                    { "data": "view_name" },
                    { "data": "order" },
                ],
                "order": [
                    [1,'asc'],
                    [4,'asc']
                ]
            });
            $('#datatable tbody').on( 'click', 'tr', function () {
                var data = tables.row( this ).data();
                idMenu = data.id;
                idGroup = data.id_group;
                menuName = data.nama;
                url = data.url;
                viewName = data.view_name;
                order = data.order;
                // console.log(data);
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    buttonEdit.attr('disabled','true');
                    buttonDisable.attr('disabled','true');
                } else {
                    tables.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    buttonEdit.removeAttr('disabled');
                    buttonDisable.removeAttr('disabled');
                }
            });

            buttonCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    resetForm();
                    cardComponent.addClass('d-none');
                });
            });

            buttonNew.click(function (e) {
                e.preventDefault();
                optionData.val('new');
                cardTitle.html('New User');
                cardComponent.removeClass('d-none');
                resetForm();
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonEdit.click(function (e) {
                e.preventDefault();
                optionData.val('edit');
                cardTitle.html('Edit User');
                cardComponent.removeClass('d-none');
                iGroup.val(idGroup);
                iNama.val(menuName);
                iUrl.val(url);
                iViewName.val(viewName);
                iOrder.val(order);

                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonDisable.click(function (e) {
                e.preventDefault();
                Swal.fire({
                    type: 'warning',
                    title: 'Disable user '+username,
                    text: 'Anda yakin ingin menonaktifkan user?',
                    showCancelButton: true
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }
                        });
                        $.ajax({
                            url: "{{ url('dashboard/master/user/disable') }}",
                            method: "post",
                            data: {username: username},
                            success: function(result) {
                                var data = JSON.parse(result);
                                console.log(data);
                                if (data.status == 'success') {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'User dinonaktifkan',
                                        onClose: function() {
                                            tables.ajax.reload();
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
                    }
                });
            });

            cardForm.submit(function (e) {
                e.preventDefault();

                let url;
                if (optionData.val() == 'new') {
                    url = '{{ url('dashboard/system/menu/add') }}';
                } else {
                    url = '{{ url('dashboard/system/menu/edit') }}';
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: url,
                    method: "post",
                    data: {id: idMenu, id_group: iGroup.val(), nama: iNama.val(), url: iUrl.val(), view_name: iViewName.val(), order: iOrder.val()},
                    success: function(result) {
                        console.log(result);
                        var data = JSON.parse(result);
                        if (data.status == 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Data Tersimpan',
                                onClose: function() {
                                    $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                        cardComponent.addClass('d-none');
                                        tables.ajax.reload();
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal Tersimpan',
                                text: 'Silahkan coba lagi',
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection