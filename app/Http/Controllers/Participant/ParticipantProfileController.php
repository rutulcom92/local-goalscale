<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use App\Models\Goal;
use App\Http\Requests\Participant\ParticipantProfileRequest;
use App\Models\ProviderType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;

class ParticipantProfileController extends Controller
{
    public function index()
    {
        $organizations = Organization::whereId(Auth::user()->organization_id)->get()->pluck('name','id');
        $user = Auth::user();

        $programID = $user->programParticipant()->select('program_id')->get()->map(function($program){
                return $program->program_id;
            })->toArray();

        foreach ($programID as $key => $value) {
            $providers[$key]['data'] = User::with('ProgramProvider')->whereHas('ProgramProvider',function($query) use ($value){
                  $query->where('program_id',$value);
                    })->get();
            $providers[$key]['program_id'] = $value;
            $providers[$key]['program_name'] = Program::find($value)->name;
        }
        return view('participant.profile')->with([
            'states' => State::get()->pluck('name', 'id'),
            'organizations' => $organizations,
            'participant' => $user,
            'participantDetail' => $user->userDetail,
            'id' => Auth::user()->id,
            'programs' => Organization::whereId($user->organization_id)->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id'),
            'providers' => $providers,
            'selected_provider' => $user->participantProvider
        ]);
    }

    public function profileUpdate(ParticipantProfileRequest $request){
        $user = Auth::user();
        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        }

        if(isset($request->inactive_user) && $request->inactive_user == 1){
            $request->request->add(['users' => ['is_active' => '0','inactive_date' => DBDateFormat(date('Y-m-d'))] + $request->users]);
            Goal::where('participant_id',$user->id)->where('status_id',goalActiveStatusId())->update([
                'status_id' => goalCloseStatusId()
            ]);

            User::setParticipantGoalCount($user->id);
            foreach($user->participantProvider()->get() as $prov){
                User::setProviderGoalCount($prov->provider_id);
                $supervisor_id = User::find($prov->provider_id)->providerSupervisor()->first()->supervisor_id;
                User::setSupervisorGoalCount($supervisor_id);
                User::setProviderAvgGoal($prov->provider_id);
                User::setSupervisorAvgGoal($supervisor_id);
            }
            User::setOrganizationGoalCount($user->organization_id);
            User::setParticipantAvgGoal($user->id);
            User::setOrganizationAvgGoal($user->organization_id);
        }
        else{
            $request->request->add(['users' => ['is_active' => '1','inactive_date' => null] + $request->users]);   
        }
        $user->update($request->users);

        $request->request->add(['userDetail' => ['dob'=> DBDateFormat($request->userDetail['dob'])] + $request->userDetail]);

        $userDetail = $user->userDetail()->update($request->userDetail);

        $user = User::find($user->id);
        
        //update new supervisor, provider and organization count
        User::setOrganizationUserCount($user->organization_id);
        User::setOrganizationProviderCount($user->organization_id);
        foreach($user->participantProvider()->get() as $prov){
           $supervisor_id = User::find($prov->provider_id)->providerSupervisor()->first()->supervisor_id;
           User::setProviderUserCount($prov->provider_id);
           User::setSupervisorUserCount($supervisor_id);
           User::setSupervisorProviderCount($supervisor_id);
        }

        User::setParticipantGoalCount($user->id);
        User::setParticipantAvgGoal($user->id);
        return response()->json([
            'status'=> 'success',
            'response'=>'Participant profile successfully Updated!'
        ]);
    }
}