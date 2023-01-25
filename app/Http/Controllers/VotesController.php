<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Votes;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;


class VotesController extends Controller
{
    public function createLike($id)
    {
        $userId = Auth::id();
        $movie = Movie::with(['genre', 'votes'])->find($id);

        if (Votes::voice($userId, $movie->id)->isEmpty()) {
            $movie->likes += 1;
            $movie->save();

            Votes::create([
                'movie_id' => $movie->id,
                'user_id' => Auth::id(),
                'votes' => true
            ]);

            $movie->load('votes', 'genre');

            return response()->json([
                'movie' => $movie,
                'status' => '',
            ]);
        } else {
            return response()->json([
                'movie' => $movie,
                'status' => 'You have already voted on this movie.',
            ]);
        }
    }

    public function createDislike($id)
    {
        $userId = Auth::id();
        $movie = Movie::with(['genre', 'votes'])->find($id);

        if (Votes::voice($userId, $movie->id)->isEmpty()) {
            $movie = Movie::find($id);
            $movie->dislikes  += 1;
            $movie->save();

            Votes::create([
                'movie_id' => $movie->id,
                'user_id' => Auth::id(),
                'votes' => true
            ]);

            $movie->load('votes', 'genre');

            return response()->json([
                'movie' => $movie,
                'status' => '',
            ]);
        } else {
            return response()->json([
                'movie' => $movie,
                'status' => 'You have already voted on this movie.',
            ]);
        }
    }
}
