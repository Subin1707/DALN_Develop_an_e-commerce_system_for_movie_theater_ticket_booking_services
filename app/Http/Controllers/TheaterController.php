<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TheaterController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Theater::query();

    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }

    $theaters = $query->latest()->paginate(10)->appends(['search' => $search]);

    return view('theaters.index', compact('theaters', 'search'));
}


    public function show(Theater $theater)
    {
        return view('theaters.show', compact('theater'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('theaters.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        Theater::create([
            'name' => $request->name,
            'address' => $request->address,     
            'total_rooms' => $request->total_rooms ?? 0,  
        ]);

        return redirect()->route('admin.theaters.index')
                         ->with('success', '🎬 Thêm rạp thành công!');
    }

    public function edit(Theater $theater)
    {
        $this->authorizeAdmin();
        return view('theaters.edit', compact('theater'));
    }

    public function update(Request $request, Theater $theater)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        $theater->update([
            'name' => $request->name,
            'address' => $request->address,     
            'total_rooms' => $request->total_rooms ?? 0, 
        ]);

        return redirect()->route('admin.theaters.index')
                         ->with('success', '✅ Cập nhật rạp thành công!');
    }

    public function destroy(Theater $theater)
    {
        $this->authorizeAdmin();

        $theater->delete();
        return redirect()->route('admin.theaters.index')
                         ->with('success', '🗑️ Xóa rạp thành công!');
    }

    // 🔒 Kiểm tra quyền admin
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
    }
}
