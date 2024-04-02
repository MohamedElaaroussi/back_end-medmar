<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'L\'image est requise.',
            'image.image' => 'L\'image doit être une image valide.',
            'image.mimes' => 'L\'image doit avoir une extension parmi :values.',
            'image.max' => 'L\'image ne doit pas dépasser :max kilo-octets.',
        ];
    }
}
