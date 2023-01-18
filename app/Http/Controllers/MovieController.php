<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->query('term', '');
        $movies = Movie::with('genre')->latest()->searchByTitle($term)->paginate(10);

        foreach ($movies as $movie) {
            $movie['description'] = Str::limit($movie['description'], 50, ' ...');
        }

        return response()->json($movies);
    }

    public function store(CreateMovieRequest $request)
    {
        $validated = $request->validated();

        $movie = Movie::create($validated);

        return response()->json($movie, 201);
    }

    public function show($id)
    {
        $movie = Movie::with('genre')->find($id);

        return response()->json($movie);
    }
}
