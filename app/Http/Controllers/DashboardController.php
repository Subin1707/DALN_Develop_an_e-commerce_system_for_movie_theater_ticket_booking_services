<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Bạn cần đăng nhập.');
        }

        /* ================= ADMIN ================= */
        if ($user->role === 'admin') {
            return view('dashboard.admin', [
                'user'        => $user,
                'userCount'   => User::count(),
                'movieCount'  => Movie::count(),
                'ticketCount' => Booking::count(),
                'revenue'     => Booking::sum('total_price'),
            ]);
        }

        /* ================= STAFF ================= */
        if ($user->role === 'staff') {
            return view('dashboard.staff', [
                'user'              => $user,
                'todayBookings'     => Booking::whereDate('created_at', today())->count(),
                'upcomingShowtimes' => Showtime::where('start_time', '>', now())->count(),
                'totalTickets'      => Booking::count(),
            ]);
        }

        /* ================= USER ================= */
        return view('dashboard.user', [
            'user'        => $user,

            // ❗ CHỈ LẤY BOOKING CỦA USER ĐANG LOGIN
            'bookings'    => Booking::where('user_id', $user->id)
                                ->with('showtime.movie')
                                ->latest()
                                ->limit(5)
                                ->get(),

            'totalBooked' => Booking::where('user_id', $user->id)->count(),
        ]);
    }

    /* ================= ADMIN - DOANH THU ================= */
    public function revenueChart()
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        $monthlyRevenueData = Booking::selectRaw(
                'MONTH(created_at) as month, SUM(total_price) as total'
            )
            ->groupBy('month')
            ->pluck('total', 'month');

        $movieRevenueData = Booking::join('showtimes', 'bookings.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.title, SUM(bookings.total_price) as total')
            ->groupBy('movies.title')
            ->pluck('total', 'movies.title');

        return view('dashboard.revenue', compact(
            'monthlyRevenueData',
            'movieRevenueData'
        ));
    }
}
