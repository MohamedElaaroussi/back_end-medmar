<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titre' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust image validation rules as needed
        ];
    }
}
