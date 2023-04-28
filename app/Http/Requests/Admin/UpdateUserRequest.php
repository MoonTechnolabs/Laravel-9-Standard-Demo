<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|max:30|email:rfc,dns|unique:users,email,' . $this->user->id,
            'role_id' => 'required',
            'password' => 'exclude_unless:checkboxshow,on|required|confirmed|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => trans('admin.strongPassword'),
            'email.unique' => trans('admin.emailExists'),
        ];
    }
}
