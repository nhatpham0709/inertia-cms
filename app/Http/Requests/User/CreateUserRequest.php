<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users|max:100',
            'email' => 'required|unique:users|max:100|email',
            'password' => 'required|min:8|max:100',
            // 're_password' => 'required|min:8|max:100|same:password',
            'name' => 'required|max:100',
            'status' => 'required',
            'role' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'username'=>'Username',
            'email' => 'Email',
            'password' => 'Password',
            // 're_password' => 'Confirm password',
            'name' => 'Fullname',
            'status' => 'Status',
            'role' => 'Role'
        ];
    }

    public function messages()
    {
        return parent::messages();
    }
}
