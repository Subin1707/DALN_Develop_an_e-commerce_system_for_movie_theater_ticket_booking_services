@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
    $monthlyRevenueLabels = json_encode($monthlyRevenue['labels']);
    $monthlyRevenueData = json_encode($monthlyRevenue['data']);
    $movieRevenueLabels = json_encode($movieRevenue['labels']);
    $movieRevenueData = json_encode($movieRevenue['data']);
@endphp

@if($user && in_array($user->role, ['admin', 'staff']))

<div class="container py-5">
    <div class="row trend_1 mb-4">
        <div class="col-md-12">
            <div class="trend_1l text-center">
                <h4 class="mb-0 text-white">
                    <i class="fa fa-bar-chart align-middle col_red me-1"></i>
                    Thống kê <span class="col_red">Doanh thu</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-header text-center">
                    <strong>Doanh thu theo tháng</strong>
                </div>
                <div class="card-body">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-header text-center">
                    <strong>Doanh thu theo phim</strong>
                </div>
                <div class="card-body">
                    <canvas id="movieRevenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const monthlyLabels = {!! $monthlyRevenueLabels !!};
    const monthlyData   = {!! $monthlyRevenueData !!};

    const movieLabels = {!! $movieRevenueLabels !!};
    const movieData   = {!! $movieRevenueData !!};

    const monthlyCanvas = document.getElementById('monthlyRevenueChart');
    if (monthlyCanvas) {
        new Chart(monthlyCanvas, {
            type: 'pie',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    data: monthlyData,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40'
                    ]
                }]
            }
        });
    }

    const movieCanvas = document.getElementById('movieRevenueChart');
    if (movieCanvas) {
        new Chart(movieCanvas, {
            type: 'doughnut',
            data: {
                labels: movieLabels,
                datasets: [{
                    data: movieData,
                    backgroundColor: [
                        '#36A2EB', '#FF6384', '#FFCE56',
                        '#4BC0C0', '#9966FF'
                    ]
                }]
            }
        });
    }
</script>
    }
@verbatim
</script>
@endverbatim

@else
<div class="container py-5 text-center text-white">
    <h4>Bạn không có quyền truy cập chức năng này</h4>
</div>
@endif

@endsection
