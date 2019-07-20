@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Profil Anda</h6>
                    </div>
                    <!-- Card Body -->
                    <form id="form_filter">
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-lg-3">URL Survey</dt>
                                <dd class="col-lg-9" id="viewUrl"></dd>

                                <dt class="col-lg-3">Last Updated</dt>
                                <dd class="col-lg-9" id="viewUpdate"></dd>
                            </dl>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-10"></div>
                                <div class="col-xl-2">
                                    <button class="btn btn-block btn-danger" id="btnEdit">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardData">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">Edit Profil</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <input type="text" class="d-none" name="nama" value="url_survey">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputNama">URL Survey</label>
                                <input type="text" class="form-control" id="inputUrl" name="info" placeholder="Alamat URL" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-2">
                                    <button type="button" class="btn btn-block btn-outline-dark" id="btnCancel">Cancel</button>
                                </div>
                                <div class="col-xl-2">
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
        const iUrlSurvey = $('#inputUrl');

        const cardComponent = $('#cardData');
        const cardForm = $('#cardForm');
        const cardTitle = $('#judulCard');
        const optionData = $('#option');

        const buttonEdit = $('#btnEdit');
        const buttonCancel = $('#btnCancel');

        const vwUrl = $('#viewUrl');
        const vwUpdate = $('#viewUpdate');

        let valUrl, valUpdate;

        function resetForm() {
            iUrlSurvey.val('');
        }

        function reloadView() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{ url('dashboard/master/set-url-survey/detail') }}',
                method: "post",
                success: function(result) {
                    // console.log(result);
                    let convrt = JSON.parse(result);
                    let data = convrt[0];
                    valUrl = data.info;
                    valUpdate = data.updated_at;
                    vwUrl.html(valUrl);
                    vwUpdate.html(moment(data.updated_at).format('DD-MM-YYYY'));
                }
            });
        }

        $(document).ready(function () {
            reloadView();

            buttonEdit.click(function (e) {
                e.preventDefault();
                cardComponent.removeClass('d-none');
                resetForm();
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    resetForm();
                    cardComponent.addClass('d-none');
                });
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: '{{ url('dashboard/master/set-url-survey/edit') }}',
                    method: "post",
                    data: $(this).serialize(),
                    success: function(result) {
                        // console.log(result);
                        let data = JSON.parse(result);
                        if (data.status = 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Data Tersimpan',
                                onClose: function() {
                                    $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                        resetForm();
                                        reloadView();
                                        cardComponent.addClass('d-none');
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal tersimpan',
                                text: data.reason,
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection