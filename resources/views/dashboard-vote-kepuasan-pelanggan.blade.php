@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kepuasan Pelanggan</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Filter</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputTanggal">Tanggal</label>
                                <input type="text" class="form-control" id="inputTanggal" name="tanggal" placeholder="Range Tanggal" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row mt-2">
                            <div class="col-xl-10"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnView">View</button>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="cardTitle">Summary Voting</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <canvas id="myChart" width="400" height="50"></canvas>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-10"></div>
                                <div class="col-xl-2 mt-2">
                                    <button type="button" class="btn btn-block btn-outline-dark" id="btnClose">Close</button>
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
        const iStatus = $('#inputPenjualan');
        const formFilter = $('#form_filter');
        const ctx = $('#myChart');

        const btnCancel = $('#btnClose');
        const btnView = $('#btnView');

        const cardComponent = $('#cardComponent');

        const iTanggal = $('#inputTanggal').daterangepicker({
            maxDate: moment(),
            startDate: moment().startOf('month'),
            endDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $(document).ready(function () {
            btnCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cardComponent.addClass('d-none');
                });
            });

            btnView.click(function (e) {
                e.preventDefault();
                let startDate = moment($('#inputTanggal').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
                let endDate = moment($('#inputTanggal').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('dashboard/voting/kepuasan-pelanggan/list') }}",
                    method: "post",
                    data: {start_date: startDate, end_date: endDate},
                    success: function(result) {
                        console.log(result);
                        let data = JSON.parse(result);
                        cardComponent.removeClass('d-none');
                        let chart = new Chart(ctx, {
                            type: 'horizontalBar',
                            data: {
                                labels: ["LIKE", "DISLIKE"],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [data.like, data.dislike],
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255,99,132,1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        ticks: {
                                            beginAtZero:true
                                        }
                                    }]
                                }
                            }
                        });
                        $('html, body').animate({
                            scrollTop: cardComponent.offset().top
                        }, 1000);
                    }
                });
            })
        });
    </script>
@endsection