<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class LogUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email non fourni',
            'email.email' => 'Adresse email non valide',
            'email.exists' => 'Cette adresse n\'existe pas',
            'password.required' => 'Mot de passe non fourni'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
