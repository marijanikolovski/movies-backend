<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'genre_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public static function scopeSearchAndFilet($query, $term = "")
    {
        $query->with('genre');

        if (!$term) {
            return $query;
        }

        return self::where(function ($querry2) use ($term) {
            $querry2->where('title', 'like', "%{$term}%")
            ->orWhereHas('genre', function ($querry3) use ($term) {
                $querry3->where('name', 'like', "%{$term}%");
            });
        });
    }
}
