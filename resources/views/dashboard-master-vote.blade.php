@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master User</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Data User</h6>
                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="btnNew" style="font-size: 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-danger" id="btnDisable" disabled>Disable</button>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">New User</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
                            <div class="form-group">
                                <label for="inputUsername">Username</label>
                                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputNamaLengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputNamaLengkap" name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off" required>
                            </div>
                            <hr style="border-width: 10px;">
                            @foreach($sidebar as $s)
                                <div class="form-group row">
                                    <div class="col-sm-2">{{ $s['group']['nama'] }}</div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            @foreach($s['menu'] as $m)
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="permission_{{ $m['id'] }}" name="menu_permission[]" value="{{ $m['id'] }}">
                                                        <label class="form-check-label" for="permission_{{ $m['id'] }}">{{ $m['nama'] }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

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