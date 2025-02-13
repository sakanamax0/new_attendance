<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
        ];
    }
}
