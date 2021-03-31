<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProviderProfileRequest extends FormRequest
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
     * Get the validation rule that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
 				$rules = [];
                $rules['user_image'] = 'mimes:png,tiff,jpeg|max:2048';
                $rules['users.first_name'] = 'required|max:50';
                $rules['users.last_name'] = 'required|max:50';
                $rules['userDetail.provider_type_id'] = 'required';
                $rules['users.email'] = 'required|email|max:199|unique:users,email,'.$this->id.',id';
                $rules["users.password"] = 'nullable|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
                $rules['users.phone'] = 'required|min:10|max:50';
                $rules['users.address'] = 'required';
                $rules['users.city'] = 'required|max:50';
                $rules['users.state_id'] = 'required';
                $rules['users.zip'] = 'required';
                $rules['users.record_num'] = 'required';
                return $rules;            
            }
            default:break;
        }
    }

     public function messages()
    {
        $ruleMsg = [];
        $ruleMsg['user_image.required'] = 'The user image must be a file of type: png, tiff, jpeg.';
        $ruleMsg['users.first_name.required'] = 'Please provide the first name.';
        $ruleMsg['users.last_name.required'] = 'Please provide the last name.';
        $ruleMsg['users.email.required'] = 'Please provide the email.';
        $ruleMsg['users.email.unique'] = 'User already exists with this email.';
        $ruleMsg['users.password.required_with'] = 'User password required with confirmation password.';
        $ruleMsg['users.password.same'] = 'User password and confirmation password does not match.';
        $ruleMsg['users.password.regex'] = 'The password must be at least 8 or more characters, at least one uppercase, at least one lowercase, at least one number and a special character.';
        $ruleMsg['users.phone.required'] = 'Please provide the phone number.';
        $ruleMsg['users.address.required'] = 'Please provide the address.';
        $ruleMsg['users.city.required'] = 'Please provide the city.';
        $ruleMsg['users.state_id.required'] = 'The state field state.';
        $ruleMsg['users.zip.required'] = 'Please provide the zip.';
        $ruleMsg['users.record_num.required'] = 'Please provide the record number.';
        return $ruleMsg;
    }

    public function withValidator($validator)
    {
        if (! $validator->fails()) {
            $input = $this->all();
            if(!empty($input['users']['password'])){
                $input['users']['password'] = Hash::make($input['users']['password']);    
            }
            else{
                unset($input['users']['password']);
            }
            $input['users']['last_modified_by'] = Auth::id();
            $input['userDetail']['last_modified_by'] = Auth::id();
            $this->replace($input);
        }
    }
}