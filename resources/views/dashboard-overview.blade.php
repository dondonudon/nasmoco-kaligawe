@extends('dashboard-layout')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vote Bulan Ini</div>
{{--                            <div class="h5 mb-0 font-weight-bold text-gray-800">0/0</div>--}}
                            <canvas id="myChart" width="400" height="50"></canvas>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->



</div>
@endsection

@section('script')
    <script>
        const ctx = $('#myChart');

        function updateChart(like, dislike) {
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: ["LIKE", "DISLIKE"],
                    datasets: [{
                        label: '# of Votes',
                        data: [like, dislike],
                        backgroundColor: [
                            'rgba(51, 204, 51, 0.2)',
                            'rgba(255, 80, 80, 0.2)',
                        ],
                        borderColor: [
                            'rgba(51, 204, 51, 1)',
                            'rgba(255,80,80,1)',
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
        }

        $(document).ready(function () {
            let startDate = moment().startOf('month').format('YYYY-MM-DD');
            let endDate = moment().endOf('month').format('YYYY-MM-DD');
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
                    // console.log(result);
                    let data = JSON.parse(result);
                    // cardComponent.removeClass('d-none');
                    // tables.clear().draw();
                    // tables.rows.add(data.detail).draw();
                    updateChart(data.like, data.dislike);

                    $('html, body').animate({
                        scrollTop: cardComponent.offset().top
                    }, 1000);
                }
            });
        })
    </script>
@endsection