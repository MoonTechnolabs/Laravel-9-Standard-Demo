<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\Common;
class ChangePasswordRequest extends FormRequest
{
    use Common;
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
            'currentpassword' => 'required',
            'password' => [
                'required',
                'string',
                'min:8', // must be at least 10 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/' // must contain a special character
            ],
            'confirmpassword'=> 'same:password'
        ];
    }
    public function messages()
    {
        return [
            'password.regex' => __('api.strongPassword'), 
            'confirmpassword.same' =>__('api.confirmPassword')       
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->fail([],$validator->errors()->first()));
    }
}
