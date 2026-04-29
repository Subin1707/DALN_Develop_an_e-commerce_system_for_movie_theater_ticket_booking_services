<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

class CommentController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request, Movie $movie)
        {
            $data = $request->validate([
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
            ]);

            $data['movies_id'] = $movie->id;
            $data['author_id'] = Auth::check() ? Auth::id() : null;

            Comment::create($data);

            return redirect()->route('movies.show', $movie->id)->with('success', 'Comment added!');
        }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
        
    }
}
