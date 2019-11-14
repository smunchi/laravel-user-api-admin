<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

    public function messages()
    {
        return [
            'dob.date_format' => 'The dob does not match the format yyyy-mm-dd.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:250',
            'last_name' => 'nullable|string|max:250',
            'email' => 'required|string|max:250|unique:users,email',
            'password' => 'required|confirmed|string|min:6|max:250',
            'mobile' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable|date|date_format:Y-m-d'
        ];
    }
}
