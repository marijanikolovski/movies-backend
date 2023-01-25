<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWatchListRequest;
use App\Models\Movie;
use App\Models\WatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WatchListController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $watchList = WatchList::with('movie', 'user')->where(['user_id' => $userId])->get();

        return response()->json($watchList);
    }

    public function store($id)
    {
        $movie = Movie::with('watchLists')->find($id);

        $watchList = new WatchList;
        $watchList->user()->associate(Auth::user());
        $watchList->movie()->associate($movie->id);
        $watchList->save();

        $watchList->load('movie');

        return response()->json($watchList, 201);
    }

    public function update($id)
    {
        $watchList = WatchList::findOrFail($id);
        $watchList->watched = true;
        $watchList->save();

        $watchList->load('movie');

        return response()->json($watchList, 201);
    }

    public function destroy($id)
    {
        $watchList = WatchList::find($id);
        $watchList->delete();

        return response()->noContent();
    }
}
