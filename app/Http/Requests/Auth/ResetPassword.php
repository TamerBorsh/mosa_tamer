<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
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
            'id-number' => ['required', 'numeric', 'digits:9'],
        ];
    }
    public function messages()
    {
        return [
            'id-number.required' => 'رقم الهوية مطلوب.',
            'id-number.numeric'  => 'رقم الهوية يجب أن يكون رقماً.',
            'id-number.digits'   => 'رقم الهوية يجب أن يتكون من 9 أرقام.',
        ];
    }
}
