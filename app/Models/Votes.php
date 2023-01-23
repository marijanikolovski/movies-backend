<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'user_id',
        'votes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public static function glas($userId, $movieID)
    {
        return self::where('user_id', 'like', "%{$userId}%")
            ->where('movie_id', 'like', "%{$movieID}%")
            ->where('votes', 'like', true)
            ->get();
    }
}
