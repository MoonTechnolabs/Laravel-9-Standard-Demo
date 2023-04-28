<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\Common;
use Illuminate\Foundation\Http\FormRequest; 
class StoreSupportRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required',
            'phone_number'=>'required',
            'message'=>'required',
            'status'=>'required'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->fail([],$validator->errors()->first()));
    }
}
