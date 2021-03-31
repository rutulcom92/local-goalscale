<?php

namespace App\Http\Requests\Goals;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\GoalStatus;
use Auth;

class GoalRequest extends FormRequest
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

                $rules['goal.name'] = 'required|max:191';
                $rules['goal.provider_id'] = 'required|max:20';
                $rules['goal.participant_id'] = 'required|max:20';

                foreach (goalScale() as $key => $value) {
                    $rules["goal.scale.$key"] = 'required|max:10000';
                }

                return $rules;
            }
            case 'PUT':
            {
                $rules = [];

                $rules['goal.activity_ranking'] = 'required|max:20';
                $rules['goal.update_text'] = 'required|max:10000';
                return $rules;
            }
            default:break;
        }
    }

    public function messages()
    {
        $messages = [];

        $messages['goal.name.required'] = 'Please provide goal name.';
        $messages['goal.provider_id.required'] = 'Please select provider.';
        $messages['goal.participant_id.required'] = 'Please select participant.';
        
        foreach (goalScale() as $key => $value) {
            $messages["goal.scale.$key.required"] = "Please provide description for scale $value".'.';
        }

        $messages['goal.activity_ranking.required'] = 'Please provide activity progress.';
        $messages['goal.update_text.required'] = 'Please provide activity text.';

        return $messages;
    }

    public function withValidator($validator)
    {
        if (! $validator->fails()) {
            $input = $this->all();
            if ($this->method() == 'POST'){

                $status_id = null;

                if (GoalStatus::whereId(1)->count() > 0) {
                    $status_id = 1;
                }

                $input['goalData'] = [
                    'name' => $input['goal']['name'],
                    'status_id' => $status_id,
                    'participant_id' => $input['goal']['participant_id'],
                    'provider_id' => $input['goal']['provider_id'],
                    'created_by' => Auth::id(),
                    'goal_start_date' => date('Y-m-d H:i:s')
                ];
            } else if($this->method() == 'PUT'){
                $input['goal'] = [
                    'activity_ranking' => $input['goal']['activity_ranking'],
                    'update_text' => $input['goal']['update_text'],
                    'date_of_activity' => date('Y-m-d H:i:s'),  
                    'parent_activity_id' => 0,
                    'participant_id' => Auth::id(),
                    'created_by' => Auth::id()
                ];
            }
            $this->replace($input);
        }
    }
}
