<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class OrganizationRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                $rules = [];
                $rules['organization.name'] = 'required|max:50';
                // $rules['organization.contact_email'] = 'required|email|max:199';
                // $rules['organization.contact_phone'] = 'required|min:10|max:50';
                // $rules['organization.address'] = 'required';
                // $rules['organization.city'] = 'required|max:50';
                // $rules['organization.state_id'] = 'required';
                // $rules['organization.zip'] = 'required';
                $rules['organization.date_added'] = 'required|date';
                $rules['organization_types'] = 'required';
                // $rules['organization.record_num'] = 'required';
                
                return $rules;
            }
            case 'PUT':
            {

                $rules = [];
                $rules['organization.name'] = 'required|max:50|unique:organizations,name,'.$this->id.',id';
                $rules['organization_types'] = 'required';
                // $rules['organization.contact_email'] = 'required|email|max:199|unique:organizations,contact_email,'.$this->id.',id';
                // $rules['organization.contact_phone'] = 'required|min:10|max:50';
                // $rules['organization.address'] = 'required';
                // $rules['organization.city'] = 'required|max:50';
                // $rules['organization.state_id'] = 'required';
                // $rules['organization.zip'] = 'required';
                return $rules;
            }
            default:break;
        }
    }

    public function messages()
    {
        $ruleMsg = [];
        $ruleMsg['organization.name.required'] = 'Please provide the organization name';
        // $ruleMsg['organization.contact_email.required'] = 'Please provide the contact email.';
        // $ruleMsg['organization.contact_phone.required'] = 'Please provide the contact phone.';
        // $ruleMsg['organization.address.required'] = 'TPlease provide the address.';
        // $ruleMsg['organization.city.required'] = 'Please provide the city.';
        // $ruleMsg['organization.state_id.required'] = 'Please select the state.';
        // $ruleMsg['organization.zip.required'] = 'Please provide the zip.';
        // $ruleMsg['organization.record_num.required'] = 'Please provide the record.';
        $ruleMsg['organization.date_added.required'] = 'Please provide the date added.'; 
        $ruleMsg['organization_types.required'] = 'Please select an organization type.';
        return $ruleMsg;
    }

    public function withValidator($validator)
    {
        if (! $validator->fails()) {
            $input = $this->all();
            if($this->method() == 'POST'){
                $input['organization']['created_by'] = Auth::id();
            }else if($this->method() == 'PUT'){
                $input['organization']['last_modified_by'] = Auth::id();
            }
            $input['organization']['is_active'] = '1';
            !empty($input['organization']['date_added']) ? $input['organization']['date_added'] = DBDateFormat($input['organization']['date_added']) : null;
            $this->replace($input);
        }
    }
}
