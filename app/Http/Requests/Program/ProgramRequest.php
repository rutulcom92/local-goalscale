<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProgramRequest extends FormRequest
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
                $rules['program.name'] = 'required|max:50';
                $rules['program.organization_id'] = 'required';
                $rules['program.date_added'] = 'required|date';
                return $rules;
            }
            case 'PUT':
            {
                $rules = [];
                $rules['program.name'] = 'required|max:50';
                $rules['program.organization_id'] = 'required';
                return $rules;
            }
            default:break;
        }
    }

    public function messages()
    {
        $ruleMsg = [];
        $ruleMsg['program.name.required'] = 'Please provide the program name.';
        $ruleMsg['program.organization_id.required'] = 'Please select the organization.';
        $ruleMsg['program.date_added.required'] = 'Please provide the date added.'; 
        return $ruleMsg;
    }

    public function withValidator($validator)
    {
        if (! $validator->fails()) {
            $input = $this->all();
            $input['program']['last_modified_by'] = Auth::id();
            empty($input['program']['is_active']) ? $input['program']['is_active'] = '0' : null;
            !empty($input['program']['date_added']) ? $input['program']['date_added'] = DBDateFormat($input['program']['date_added']) : null;
            $this->replace($input);
        }
    }
}
