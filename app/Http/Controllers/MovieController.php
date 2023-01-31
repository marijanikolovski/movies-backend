<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Models\Movie;
use App\Mail\MovieCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->query('term', '');
        $movies = Movie::with('genre', 'watchLists')->latest()->searchAndFilet($term)->paginate(10);

        foreach ($movies as $movie) {
            $movie['description'] = Str::limit($movie['description'], 50, ' ...');
        }

        return response()->json($movies);
    }

    public function store(CreateMovieRequest $request)
    {
        $validated = $request->validated();

        $movie = Movie::create($validated);

        Mail::to(auth()->user())->send(new MovieCreated($movie));

        return response()->json($movie, 201);
    }

    public function show($id)
    {
        $movie = Movie::with('genre', 'votes', 'watchLists')->find($id);

        $movie->increment('visits', 1);

        return response()->json($movie);
    }

    public function showTopMovies()
    {
        $popularMovies = Movie::getTopMovies();

        return response()->json($popularMovies);
    }

    public function showRelatedMovies($id)
    {
        $movie = Movie::with('genre')->find($id);

        $relatedMovies = Movie::getRelatedMovies($movie->genre_id, $id);

        return response()->json($relatedMovies);
    }
}
