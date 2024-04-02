<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lien' => 'required|url',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ];
    }

    public function messages()
    {
        return [
            'lien.required' => 'The link field is required.',
            'lien.url' => 'The link must be a valid URL.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Supported image formats are jpeg, png, jpg, and gif.',
            'image.max' => 'The image size must be less than 2MB.',
        ];
    }
}
