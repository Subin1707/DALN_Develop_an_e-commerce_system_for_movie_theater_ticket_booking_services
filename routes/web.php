<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\StaffAccountController;
use App\Http\Controllers\SupportReplyController;
use App\Http\Controllers\SupportTicketController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{theater}', [TheaterController::class, 'show'])->name('theaters.show');

Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

Route::view('/about', 'about')->name('aboutme');

/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* ================= PROFILE ================= */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | BOOKING - USER
    |--------------------------------------------------------------------------
    */
    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])
        ->name('bookings.choose');

    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings/payment/preview', [BookingController::class, 'paymentPreview'])
        ->name('bookings.payment.preview');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    // USER HISTORY
    Route::get('/my-bookings', [BookingController::class, 'history'])
        ->name('bookings.history');

    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    // 🔲 QR CODE VÉ (USER XEM)
    Route::get('/my-bookings/{booking}/qr', [BookingController::class, 'qr'])
        ->name('bookings.qr');

    // 🔲 PDF VÉ
    Route::get('/my-bookings/{booking}/pdf', [BookingController::class, 'exportPdf'])
        ->name('bookings.pdf');

    // COMMENTS
    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
        ->name('movies.comments.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/dashboard/revenue', [DashboardController::class, 'revenue'])
            ->name('dashboard.revenue');

        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);

        // ADMIN XEM BOOKING
        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);

        Route::resource('comments', CommentController::class)
            ->only(['index', 'destroy']);

        Route::resource('staffs', StaffAccountController::class);
    });

/*
|-------------------------------------------------------------------------- 
| STAFF
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);

        // ✅ STAFF XÁC NHẬN THANH TOÁN (FIX: PATCH → POST)
        Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
            ->name('bookings.confirm');

        // 🔥 STAFF SCAN QR → CHECK-IN
        Route::get('/scan/{booking_code}', [BookingController::class, 'scanQr'])
            ->name('bookings.scan');
    });

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| SUPPORT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('support')
    ->name('support.')
    ->group(function () {

        Route::get('/', [SupportTicketController::class, 'index'])->name('index');
        Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
        Route::post('/', [SupportTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [SupportTicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [SupportReplyController::class, 'store'])
            ->name('reply.store');
    });
