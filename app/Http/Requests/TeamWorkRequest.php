<?php

// app/Http/Requests/TeamWorkRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamWorkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom' => 'required|string',
            'role' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation rules as needed
        ];
    }
}
