<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegistrationRequest extends FormRequest
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

            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:25',

        ];
    }

    public function getAttributes()
    {
        return array_merge(
            $this->only(['name', 'email']),
            ['password' => Hash::make($this->get('password'))]
        );
    }
}
