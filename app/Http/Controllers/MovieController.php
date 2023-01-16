<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function store(CreateMovieRequest $request)
    {
        $validated = $request->validated();

        $movie = Movie::create($validated);

        return response()->json($movie, 201);
    }
}
