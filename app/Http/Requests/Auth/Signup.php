<?php

namespace App\Http\Requests\Auth;

use App\Abstracts\Http\FormRequest;

class Signup extends FormRequest
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
            'company_name' => 'required',
            // 'company_email' => 'required|email',
            'user_email' => 'required|email',
            'password' => 'required|string|confirmed'
        ];
    }
}
