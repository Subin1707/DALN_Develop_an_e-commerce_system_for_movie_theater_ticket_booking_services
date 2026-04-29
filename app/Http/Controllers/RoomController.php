<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('theater')->latest()->paginate(10);
        $user = Auth::user(); 
        
        return view('rooms.index', compact('rooms', 'user'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $theaters = Theater::all();
        return view('rooms.create', compact('theaters'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', '🎬 Thêm phòng chiếu thành công!');
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $this->authorizeAdmin();
        $theaters = Theater::all();
        return view('rooms.edit', compact('room', 'theaters'));
    }

    public function update(Request $request, Room $room)
    {
        $this->authorizeAdmin();

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', '✅ Cập nhật thành công!');
    }

    public function destroy(Room $room)
    {
        $this->authorizeAdmin();
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', '🗑️ Xóa thành công!');
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, '🚫 Bạn không có quyền thực hiện thao tác này.');
        }
    }
}
