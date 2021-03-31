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
use App\Models\ParticipantProvider;
use App\Http\Requests\Participant\ParticipantRequest;
use App\Models\ProviderType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;

use App\Events\GoalEvents;

class ParticipantController extends Controller
{
    public function index()
    {
        if(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == providerUserTypeId()) {
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::whereOrganizationId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');

            $orgTypeID = Auth::user()->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::whereIn('org_type_id',$orgTypeID)->orderBy('name','ASC')->get()->pluck('name','id');
        }else if (Auth::user()->user_type_id == organizationAdminUserTypeId()) {
            $user = Auth::user();
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');
            $providerType = ProviderType::orderBy('name','ASC')->get()->pluck('name','id');
        }else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::orderBy('name','ASC')->get()->pluck('name','id');
            $providerType = ProviderType::orderBy('name','ASC')->get()->pluck('name','id');
        }

        return view('participant.index')->with([
             'organizations' => $organizations,
             'provider_types' => $providerType,
             'programs' => $programs,
            ]);
    }

     public function list(Request $request)
    {
        return User::getParticipantDt($request);
    }


    public function create(Request $request)
    {
        $orgID = $request->get('id');
        $programID = $request->get('pid');
        if($orgID != ''){
            $organizations = Organization::whereId($orgID)->orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::whereOrganizationId($orgID)->orderBy('name','ASC')->get()->pluck('name','id');
            $providers = array();

        }elseif($programID != ''){
            $orgID = Program::whereId($programID)->get()->first();
            $orgID = $orgID->organization_id;
            $organizations = Organization::whereId($orgID)->orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::whereId($programID)->orderBy('name','ASC')->get()->pluck('name','id');
            $providers =  User::whereHas('ProgramProvider',function($query) use ($programID){
                      $query->where('program_id',$programID);
                        })->get()->pluck('full_name', 'id');

        }elseif(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == providerUserTypeId() || Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
            $programs = array();
            $providers = array();
        }
        else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = array();
            $providers = array();
        }
        return view('participant.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'organizations' => $organizations,
            'providers' => $providers,
            'selected_providers' => array(),
            'selected_organization' => array(),
            'programs' => $programs,
            'selected_programs' => array(),
            'org_id' => isset($orgID) ? $orgID : '',
            'pid' => isset($programID) ? $programID : ''
        ]);
    }

    public function store(ParticipantRequest $request)
    {
        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
        }else {
            $request->request->add(['users' => ['image' => 'noImg.jpg'] + $request->users]);
        }

        // $password = Hash::make('123456');

        $request->request->add(['users' => ['user_type_id'=> participantUserTypeId()] + $request->users]);
        $user = User::create($request->users);
        if(isset($request->user_set_password)){
            $user->notify(new SetPasswordNotification($user->email));
        } 

        $organization = Organization::find($request->users['organization_id'])->addUser();
        $request->request->add(['userDetail' => ['user_id' => $user->id,'created_by' => auth()->user()->id,'dob'=> DBDateFormat($request->userDetail['dob'])] + $request->userDetail]);
        $userDetail = UserDetail::create($request->userDetail);
        
        // $user->userDetail->provider()->first()->userDetail->addUser();
        // $user->userDetail->provider()->first()->providerSupervisor()->first()->supervisor()->first()->userDetail->addUser();

        $user->programParticipant()->sync($request->user_programs['program_id']);
        if (!empty($request->participant_provider['provider_id']) && count($request->participant_provider['provider_id']) > 0) {
            foreach ($request->participant_provider['provider_id'] as $key => $value) {
               $participantProvider['participant_id'] = $user->id;
               $participantProvider['provider_id'] = explode(',',$value)[0];
               $participantProvider['program_id'] = explode(',',$value)[1];
               $participantProvider['created_by'] = Auth::id();
               ParticipantProvider::create($participantProvider);
               $supervisor_id = User::find(explode(',',$value)[0])->providerSupervisor()->first()->supervisor_id;
               User::setProviderUserCount(explode(',',$value)[0]);
               User::setSupervisorUserCount($supervisor_id);
            }
        }

        if($user->id > 0){

            $request->event_id = 21;
            $request->related_id = $user->id;
            $request->email = $user->email;
            $request->desc = $user->full_name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Participant successfully added!',
                'redirect' => route('participant.edit', $user->id)
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'response' => 'Something went wrong!'
            ]);
        }
    }

    public function edit($id){

        if(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == providerUserTypeId() || Auth::user()->user_type_id == participantUserTypeId()){
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
        }
        else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
        }

        $user = User::find($id);

        $orgID = $user->organization_id;
        $organization = Organization::whereId($orgID)->first();

        $programID = $user->programParticipant()->select('program_id')->get()->map(function($program){
                return $program->program_id;
            })->toArray();

        foreach ($programID as $key => $value) {
            $providers[$key]['data'] = User::with('ProgramProvider')->whereHas('ProgramProvider',function($query) use ($value){
                  $query->where('program_id',$value);
                    })->orderBy('first_name')->get();
            $providers[$key]['program_id'] = $value;
            $providers[$key]['program_name'] = Program::find($value)->name;
        }
        return view('participant.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'organizations' => $organizations,
            'organization' => $organization,
            'participant' => $user,
            'participantDetail' => $user->userDetail,
            'id' => $id,
            'programs' => Organization::whereId($user->organization_id)->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id'),
            'selected_programs' => $programID,
            'selected_organization' => $user->organization_id,
            'providers' => $providers,
            'selected_provider' => $user->participantProvider,
            'org_id' => '',
            'pid' => ''
        ]);
    }

    public function update($id, ParticipantRequest $request){
        $user = User::find($id);
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

       $old_user = $user;
   
       $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);
       $user->update($request->users);
       $user->programParticipant()->detach();
       $user->programParticipant()->sync($request->user_programs['program_id']);

       ParticipantProvider::withoutGlobalScopes()->where('participant_id', $id)->forceDelete();
       if (!empty($request->participant_provider['provider_id']) && count($request->participant_provider['provider_id']) > 0) {
           foreach ($request->participant_provider['provider_id'] as $key => $value) {
              $participantProvider['participant_id'] = $id;
              $participantProvider['provider_id'] = explode(',',$value)[0];
              $participantProvider['program_id'] = explode(',',$value)[1];
              $participantProvider['created_by'] = Auth::id();
              ParticipantProvider::create($participantProvider);
           }
       }
      
       $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id,'dob'=> DBDateFormat($request->userDetail['dob'])] + $request->userDetail]);
       $userDetail = $user->userDetail()->update($request->userDetail);

       $user = User::find($user->id);

       //update previous supervisor, provider and organization count
       User::setOrganizationUserCount($old_user->organization_id);
       User::setOrganizationProviderCount($old_user->organization_id);
       foreach($old_user->participantProvider()->get() as $prov){
          $supervisor_id = User::find($prov->provider_id)->providerSupervisor()->first()->supervisor_id;
          User::setProviderUserCount($prov->provider_id);
          User::setSupervisorUserCount($supervisor_id);
          User::setSupervisorProviderCount($supervisor_id);
       }

       //update new supervisor, provider and organization count
       User::setOrganizationUserCount($user->organization_id);
       User::setOrganizationProviderCount($user->organization_id);
       foreach($user->participantProvider()->get() as $prov){
          $supervisor_id = User::find($prov->provider_id)->providerSupervisor()->first()->supervisor_id;
          User::setProviderUserCount($prov->provider_id);
          User::setSupervisorUserCount($supervisor_id);
          User::setSupervisorProviderCount($supervisor_id);
       }

        $request->event_id = 22;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->full_name;
        event(new GoalEvents($request));

       return response()->json([
           'status'=> 'success',
           'response'=>'Participant successfully Updated!',
           'redirect' => route('participant.edit', $id)
       ]);
   }

    public function validateEmail(Request $request)
    {

        if(empty($request->input('id'))){
            $validator = Validator::make($request->all(), [
                'email'  => 'required|email|unique:users',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users,email,'.$request->get('id').',id',
            ]);
        }

        if ($validator->fails()) {
            echo json_encode("User already exists with this email.");
        }else{
            echo json_encode("true");
        }
    }

    function getOrganizationPrograms(Request $request){

        if($request->get('organizationID')){
            if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
                $programs = Program::whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');
            }else{
                   $programs =  Organization::whereId($request->get('organizationID'))->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id');
            }
            //return view
            return response()->json([
                'status' => 'success',
                'response' => view('participant.select-organization-programs',['programs' => $programs
                ])->render()
            ]);
        }
        return;
    }

    function getParticipantProviders(Request $request){
        if($request->get('programID')){
            $pID = $request->get('programID');
            foreach ($pID as $key => $value) {
             if(Auth::user()->user_type_id == providerUserTypeId()){
                $providers[$key]['data'] = User::with('ProgramProvider')->whereHas('ProgramProvider',function($query) use ($value){
                      $query->where('program_id',$value);
                      $query->where('provider_id',Auth::user()->id);
                        })->orderBy('first_name')->get();
            }else{
                $providers[$key]['data'] = User::with('ProgramProvider')->whereHas('ProgramProvider',function($query) use ($value){
                      $query->where('program_id',$value);
                        })->orderBy('first_name')->get();
            }
                $providers[$key]['program_id'] = $value;
                $providers[$key]['program_name'] = Program::find($value)->name;
            }

            //return view
            return response()->json([
                'status' => 'success',
                'response' => view('participant.select-participant-providers',['providers' =>  $providers
                ])->render()
            ]);
        }
        //return view
            return response()->json([
                'status' => 'success',
                'response' => ''
            ]);
    }
}
