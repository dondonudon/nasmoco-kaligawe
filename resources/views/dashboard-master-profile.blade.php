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
                                <dt class="col-lg-3">Username</dt>
                                <dd class="col-lg-9" id="viewUsername"></dd>

                                <dt class="col-lg-3">Nama Lengkap</dt>
                                <dd class="col-lg-9" id="viewNamaLengkap"></dd>

                                <dt class="col-lg-3">Tanggal Terdaftar</dt>
                                <dd class="col-lg-9" id="viewTglDaftar"></dd>
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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputNama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputNama" name="nama" placeholder="Nama Lengkap" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password Lama</label>
                                <input type="password" class="form-control" id="inputOldPassword" name="old_password" placeholder="Ketik password lama anda disini ..." autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password Baru</label>
                                <input type="password" class="form-control" id="inputNewPassword" name="new_password" placeholder="Ketik password baru anda disini ..." autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Ulangi Password Baru</label>
                                <input type="password" class="form-control" id="inputRepeatPassword" name="repeat_password" placeholder="Silahkan ketik password baru anda ..." autocomplete="off" onkeyup="checkRepeat()" required>
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
        const iNama = $('#inputNama');
        const iOldPassword = $('#inputOldPassword');
        const iNewPassword = $('#inputNewPassword');
        const iRepeatPassword = $('#inputRepeatPassword');

        const cardComponent = $('#cardData');
        const cardForm = $('#cardForm');
        const cardTitle = $('#judulCard');
        const optionData = $('#option');

        const buttonEdit = $('#btnEdit');
        const buttonCancel = $('#btnCancel');

        const vwUsername = $('#viewUsername');
        const vwNama = $('#viewNamaLengkap');
        const vwTglDaftar = $('#viewTglDaftar');

        let valUsername, valNama, valTglDaftar, statRepeat;

        function resetForm() {
            iNama.val('');
            iOldPassword.val('');
            iNewPassword.val('');
            iRepeatPassword.val('');
        }

        function checkRepeat() {
            let newPass = iNewPassword.val();
            let repPass = iRepeatPassword.val();
            console.log(repPass);
            if (newPass == repPass) {
                iRepeatPassword.notify("Password sama","success");
                statRepeat = 1;
            } else {
                iRepeatPassword.notify("Password berbeda","warn");
                statRepeat = 0;
            }
        }

        function reloadView() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{ url('dashboard/master/profile/detail') }}',
                method: "post",
                success: function(result) {
                    // console.log(result);
                    let convrt = JSON.parse(result);
                    let data = convrt[0];
                    valUsername = data.username;
                    valNama = data.nama_lengkap;
                    valTglDaftar = data.created_at;
                    vwUsername.html(data.username);
                    vwNama.html(data.nama_lengkap);
                    vwTglDaftar.html(moment(data.created_at).format('DD-MM-YYYY'));
                }
            });
        }

        $(document).ready(function () {
            reloadView();

            buttonEdit.click(function (e) {
                e.preventDefault();
                cardComponent.removeClass('d-none');
                resetForm();
                iNama.val(valNama);
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
                if (statRepeat == 0) {
                    iRepeatPassword.notify("Password berbeda","warn");
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });
                    $.ajax({
                        url: '{{ url('dashboard/master/profile/edit') }}',
                        method: "post",
                        data: $(this).serialize(),
                        success: function(result) {
                            console.log(result);
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
                }
            });
        })
    </script>
@endsection