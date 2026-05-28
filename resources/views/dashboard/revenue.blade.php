@extends('layouts.app')

@section('title', 'Thống kê doanh thu')

@section('content')
@php
    $monthNames = [
        1 => 'Tháng 1',
        2 => 'Tháng 2',
        3 => 'Tháng 3',
        4 => 'Tháng 4',
        5 => 'Tháng 5',
        6 => 'Tháng 6',
        7 => 'Tháng 7',
        8 => 'Tháng 8',
        9 => 'Tháng 9',
        10 => 'Tháng 10',
        11 => 'Tháng 11',
        12 => 'Tháng 12',
    ];

    $monthlyLabels = $monthlyRevenueData->keys()
        ->map(fn ($month) => $monthNames[(int) $month] ?? 'Tháng ' . $month)
        ->values();

    $monthlyData = $monthlyRevenueData->values();
    $movieLabels = $movieRevenueData->keys()->values();
    $movieData = $movieRevenueData->values();
    $totalRevenue = $monthlyRevenueData->sum();
@endphp

<div class="revenue-dashboard">
    <section class="revenue-hero">
        <div>
            <span class="revenue-kicker">Báo cáo</span>
            <h3>Thống kê doanh thu</h3>
            <p>Theo dõi doanh thu theo tháng và theo phim trong hệ thống Q&HCinema.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary revenue-back-btn">
            <i class="fa fa-arrow-left"></i> Quay lại dashboard
        </a>
    </section>

    <section class="revenue-summary">
        <div class="revenue-total-card">
            <span><i class="fa fa-money"></i></span>
            <div>
                <small>Tổng doanh thu</small>
                <strong>{{ number_format($totalRevenue) }} đ</strong>
            </div>
        </div>

        <div class="revenue-total-card">
            <span><i class="fa fa-calendar"></i></span>
            <div>
                <small>Tháng có dữ liệu</small>
                <strong>{{ $monthlyRevenueData->count() }}</strong>
            </div>
        </div>

        <div class="revenue-total-card">
            <span><i class="fa fa-film"></i></span>
            <div>
                <small>Phim phát sinh doanh thu</small>
                <strong>{{ $movieRevenueData->count() }}</strong>
            </div>
        </div>
    </section>

    <section class="revenue-chart-grid">
        <div class="revenue-chart-card">
            <div class="chart-head">
                <h5>Doanh thu theo tháng</h5>
                <span class="cinema-badge neutral">Monthly</span>
            </div>
            <canvas id="monthlyRevenueChart" height="150"></canvas>
        </div>

        <div class="revenue-chart-card">
            <div class="chart-head">
                <h5>Doanh thu theo phim</h5>
                <span class="cinema-badge neutral">Movies</span>
            </div>
            <canvas id="movieRevenueChart" height="150"></canvas>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .revenue-dashboard {
        display: grid;
        gap: 22px;
    }

    .revenue-hero,
    .revenue-total-card,
    .revenue-chart-card {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .revenue-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 28px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .revenue-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .revenue-hero h3 {
        margin: 7px 0;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .revenue-hero p {
        margin: 0;
        color: #cbd5e1;
    }

    .revenue-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
        white-space: nowrap;
    }

    .revenue-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .revenue-total-card {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 112px;
        padding: 20px;
    }

    .revenue-total-card span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border-radius: 8px;
        background: rgba(250,204,21,.14);
        color: #facc15;
        font-size: 1.35rem;
    }

    .revenue-total-card small {
        display: block;
        color: #94a3b8;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .revenue-total-card strong {
        display: block;
        margin-top: 6px;
        color: #fff;
        font-size: 1.45rem;
    }

    .revenue-chart-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .revenue-chart-card {
        padding: 20px;
    }

    .chart-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .chart-head h5 {
        margin: 0;
        color: #fff;
        font-weight: 900;
    }

    @media (max-width: 991.98px) {
        .revenue-summary,
        .revenue-chart-grid {
            grid-template-columns: 1fr;
        }

        .revenue-hero {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyLabels = @json($monthlyLabels);
    const monthlyData = @json($monthlyData);
    const movieLabels = @json($movieLabels);
    const movieData = @json($movieData);

    const chartColors = ['#e94560', '#facc15', '#38bdf8', '#22c55e', '#a78bfa', '#fb923c', '#14b8a6'];

    const monthlyCanvas = document.getElementById('monthlyRevenueChart');
    if (monthlyCanvas) {
        new Chart(monthlyCanvas, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Doanh thu',
                    data: monthlyData,
                    backgroundColor: '#e94560',
                    borderRadius: 8
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#e5e7eb' } }
                },
                scales: {
                    x: { ticks: { color: '#cbd5e1' }, grid: { color: 'rgba(255,255,255,.06)' } },
                    y: { ticks: { color: '#cbd5e1' }, grid: { color: 'rgba(255,255,255,.06)' } }
                }
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
                    backgroundColor: chartColors
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#e5e7eb' } }
                }
            }
        });
    }
</script>
@endpush
