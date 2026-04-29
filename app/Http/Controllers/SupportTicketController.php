<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /* ================= USER / STAFF / ADMIN ================= */

    // Danh sách ticket
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Admin & Staff: xem tất cả
        if (in_array($user->role, ['admin', 'staff'])) {
            $tickets = SupportTicket::latest()->paginate(10);
        }
        // User thường: chỉ xem ticket của mình
        else {
            $tickets = SupportTicket::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('support.index', compact('tickets'));
    }

    // Form tạo ticket
    public function create()
    {
        // Booking của user (để chọn nếu có)
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('support.create', compact('bookings'));
    }

    // Lưu ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'category'   => 'required|in:booking,payment,movie,theater,other',
            'message'    => 'required|string',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $ticket = SupportTicket::create([
            'user_id'    => Auth::id(),
            'booking_id' => $request->booking_id,
            'subject'    => $request->subject,
            'category'   => $request->category,
            'message'    => $request->message,
            'status'     => 'open',
        ]);

        // Reply đầu tiên
        $ticket->replies()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()
            ->route('support.index')
            ->with('success', '🎫 Đã gửi yêu cầu hỗ trợ');
    }

    // Xem chi tiết ticket
    public function show(SupportTicket $ticket)
    {
        /** @var User $user */
        $user = Auth::user();

        // User chỉ được xem ticket của mình
        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        return view('support.show', compact('ticket'));
    }

    /* ================= STAFF ================= */

    public function staffIndex()
    {
        $this->authorizeStaff();

        $tickets = SupportTicket::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhereNull('assigned_to');
            })
            ->latest()
            ->paginate(10);

        return view('support.index', compact('tickets'));
    }

    /* ================= ADMIN ================= */

    public function adminIndex()
    {
        $this->authorizeAdmin();

        $tickets = SupportTicket::latest()->paginate(15);

        return view('support.index', compact('tickets'));
    }

    /* ================= HELPERS ================= */

    private function authorizeStaff(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (!in_array($user->role, ['staff', 'admin'])) {
            abort(403);
        }
    }

    private function authorizeAdmin(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403);
        }
    }
}
