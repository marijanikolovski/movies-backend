<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'cover_image' => ['regex:/^(https?:)?\/\/?[^\'"<>]+?\.(jpg|jpeg|png)(.*)?$/'],
            'genre_id' => 'integer|exists:genres,id',
        ];
    }
}
