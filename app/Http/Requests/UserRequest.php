<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name ? strip_tags(trim($this->name)) : null,
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            'phone' => $this->phone ? strip_tags(trim($this->phone)) : null,
        ]);
    }

    public function rules(): array
    {
        $userId = $this->route('c_user')?->id ?? $this->route('c_user');

        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('user', 'email')->ignore($userId)
            ],

            'phone' => [
                'required',
                'string',
                'min:6',
                \Illuminate\Validation\Rule::unique('user', 'phone')->ignore($userId)
            ],

            'password' => $this->isMethod('POST') ? ['required', 'min:6'] : ['nullable', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'Name must be at least 3 letters.',
            'name.max' => 'Name should not be greater than 100 letters.',

            'phone.required' => 'The phone field is required.',
            'phone.unique' => 'This phone number is already duplicated.',
            'phone.min' => 'Phone must be at least 6 numbers.',

            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already duplicated.',

            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ];
    }
}