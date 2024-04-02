<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titre' => 'required|string',
            'date' => 'required',
            'status' => 'required|string',
            'prix' => 'required',
            'description' => 'required|string',
        ];
    }
}
