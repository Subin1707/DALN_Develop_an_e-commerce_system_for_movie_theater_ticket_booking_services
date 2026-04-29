<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportReplyController extends Controller
{
    public function store(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user();

        /* ================= AUTHORIZATION ================= */

        // USER: chỉ được reply ticket của chính mình
        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        // STAFF: chỉ reply ticket được assign cho mình (hoặc chưa assign)
        if (
            $user->role === 'staff'
            && $ticket->assigned_to !== null
            && $ticket->assigned_to !== $user->id
        ) {
            abort(403);
        }

        /* ================= CREATE REPLY ================= */

        $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        /* ================= UPDATE STATUS ================= */

        // Staff / Admin trả lời → đổi trạng thái
        if (in_array($user->role, ['staff', 'admin'])) {
            if (in_array($ticket->status, ['open', 'processing'])) {
                $ticket->update([
                    'status' => 'answered',
                ]);
            }
        }

        return back()->with('success', '💬 Đã gửi phản hồi');
    }
}
