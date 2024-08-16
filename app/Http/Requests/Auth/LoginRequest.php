<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login_type' => ['required', 'string', 'min:3'], // Ensure the login type is a string, required, and at least 3 characters long
            'password' => ['required', 'string', 'min:6'], // Ensure the password is a string, required, and at least 6 characters long
            'guard' => ['required', 'string', 'in:admin,web'], // Validate the guard field to be one of the specified values
            'remember_me' => ['sometimes', 'boolean'], // The remember_me field is optional and should be a boolean
        ];
    }
    public function messages()
    {
        return [
            'login_type.required' => 'اليوزرنيم أو رقم الموبايل فارغ',
            'login_type.string'   => 'يجب أن يكون نوع تسجيل الدخول نصًا.',
            'login_type.min'      => 'يجب أن يكون اليوزرنيم على الأقل :min أحرف.',

            'password.required'  => 'حقل كلمة المرور مطلوب.',
            'password.string'    => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min'       => 'يجب أن تكون كلمة المرور على الأقل :min أحرف.',

            'guard.required'     => 'حقل الحارس مطلوب.',
            'guard.string'       => 'يجب أن يكون الحارس نصًا.',
            'guard.in'           => 'القيمة المحددة للحارس غير صحيحة.',

            'remember_me.boolean' => 'يجب أن يكون حقل تذكرني صحيحًا أو خطأ.',
        ];
    }
}
