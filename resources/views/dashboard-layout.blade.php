@php
    $sidebar = App\Http\Controllers\DashboardSidebar::getSidebar();
    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nasmoco Siliwangi - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free-5.9.0-web/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/FixedColumns-3.2.5/css/fixedColumns.bootstrap4.css') }}">

    <!-- DateRangePicker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker-master/daterangepicker.css') }}">

    @yield('style')

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <img src="{{ asset('img/NasmocoSiliwangi.png') }}" class="img-thumbnail" width="65%" alt="...">
{{--            <div class="sidebar-brand-icon rotate-n-15">--}}
{{--                <i class="fas fa-car"></i>--}}
{{--            </div>--}}
{{--            <div class="sidebar-brand-text mx-3">NASMOCO Siliwangi</div>--}}
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        @if($routeName == 'dashboard_overview')
            <li class="nav-item active">
        @else
            <li class="nav-item">
        @endif
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        @foreach($sidebar as $s)
            <!-- Nav Item - Pages Collapse Menu -->
            @if(in_array($routeName,$s['group']['url']))
                <li class="nav-item active">
            @else
                <li class="nav-item">
            @endif
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{ $s['group']['id_target'] }}" aria-expanded="true" aria-controls="{{ $s['group']['id_target'] }}">
                    <i class="{{ $s['group']['icon'] }}"></i>
                    <span>{{ $s['group']['nama'] }}</span>
                </a>
                <div id="{{ $s['group']['id_target'] }}" class="collapse" aria-labelledby="{{ $s['group']['id_target'] }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sub Menu:</h6>
                        @foreach($s['menu'] as $m)
                            <a class="collapse-item" href="{{ url($m['url']) }}">{{ $m['nama'] }}</a>
                        @endforeach
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        @endforeach

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ \Illuminate\Support\Facades\Session::get('nama_lengkap') }}</span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Profile--}}
{{--                            </a>--}}
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Settings--}}
{{--                            </a>--}}
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Activity Log--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            @if(session('permission'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Permission denied.</strong> {{ session('permission') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah anda ingin keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Silahkan klik tombol logout dibawah untuk mengakhiri sesi ini.</div>
            <div class="modal-footer">
                <button class="btn btn-outline-dark" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" type="button" id="btnLogout">Logout</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- SweetAlert 2 -->
<script src="{{ asset('vendor/sweetalert2-8.13.1/sweetalert2.all.min.js') }}"></script>

<!-- DateRangePicker -->
<script src="{{ asset('vendor/notify.js/notify.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- DataTables -->
<script type="text/javascript" src="{{ asset('vendor/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedColumns-3.2.5/js/dataTables.fixedColumns.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedColumns-3.2.5/js/fixedColumns.bootstrap4.min.js') }}"></script>

<!-- DateRangePicker -->
<script type="text/javascript" src="{{ asset('vendor/daterangepicker-master/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterangepicker-master/daterangepicker.js') }}"></script>

<script type="text/javascript">
    const btnLogout = $('#btnLogout');
    btnLogout.click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ url('dashboard/session/flush') }}",
            method: "get",
            success: function(result) {
                console.log(result);
                var data = JSON.parse(result);
                if (data.status == 'success') {
                    document.location.replace('{{ url('dashboard/login') }}');
                } else {
                    Swal.fire({
                        type: 'info',
                        title: 'Gagal',
                    });
                }
            }
        });
    })
</script>

@yield('script')

</body>

</html>
