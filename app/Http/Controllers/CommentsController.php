<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Movie;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store($id, CreateCommentRequest $request)
    {
        $validated = $request->validated();

        $movie = Movie::with(['comments', 'comments.user'])->find($id);
        $comment = new Comment;
        $comment->content = $validated['content'];
        $comment->user()->associate(Auth::user());
        $comment->movie()->associate($movie);
        $comment->save();

        return response()->json($comment, 201);
    }
}
