<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use App\Models\Goal;
use App\Models\ProgramSupervisor;
use App\Models\ProviderSupervisor;
use App\Http\Requests\Provider\ProviderRequest;
use App\Models\ProviderType;
use App\Models\OrganizationOrgType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;

use App\Events\GoalEvents;

class ProviderController extends Controller
{
    public function index()
    {
        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $programs = Program::whereHas('ProgramSupervisors',function($query){
              $query->where('supervisor_id',Auth::user()->id);
            })->orderBy('name','ASC')->get()->pluck('name','id');
            $user = Auth::user();
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');

            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');

        }else if(Auth::user()->user_type_id == organizationAdminUserTypeId()){

            $user = Auth::user();
            $userDetail = $user->userDetail()->get()->where('user_id',$user->id)->first();
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
            $organizations = Organization::orderBy('name','ASC')->whereId(Auth::user()->organization_id)->get()->pluck('name','id');
            $programs = Program::whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');;
        }else{
            $providerType = ProviderType::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::orderBy('name','ASC')->get()->pluck('name','id');
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
        }

        return view('provider.index')->with([
            'organizations' => $organizations,
            'programs' => $programs,
            'provider_types' => $providerType,
        ]);
    }

    public function list(Request $request)
    {
        return User::getProviderDt($request);
    }

    public function create(Request $request)
    {
         $orgID = $request->get('id');
         $programID = $request->get('pid');
         if($orgID != ''){
            $organizations = Organization::whereId($orgID)->get()->pluck('name','id');
            $programs   = Program::orderBy('name','ASC')->whereOrganizationId($orgID)->get()->pluck('name','id');
            $orgTypeID = OrganizationOrgType::select('org_type_id')->whereOrganizationId($orgID)->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

           $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
           $supervisors = array();
        }else if($programID != ''){
            $orgID = Program::whereId($programID)->get()->first();
            $orgID = $orgID->organization_id;
            $organizations = Organization::whereId($orgID)->get()->pluck('name','id');
            $programs   = Program::orderBy('name','ASC')->whereId($programID)->get()->pluck('name','id');
            $orgTypeID = OrganizationOrgType::select('org_type_id')->whereOrganizationId($orgID)->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

           $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');

            $supervisors = User::whereHas('ProgramSupervisor', function($query) use($programID){
                        $query->whereProgramId($programID);
            })->get()->pluck('full_name','id');
        }elseif(Auth::user()->user_type_id == organizationAdminUserTypeId() || Auth::user()->user_type_id == supervisorUserTypeId()){

            $user = Auth::user();
            $userDetail = $user->userDetail()->get()->where('user_id',$user->id)->first();
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
            $programs = array();
            $organizations = Organization::where('id',$user->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
             $supervisors = array();

        }else{

            $providerType = ProviderType::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = array();
            $programs = array();
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
            $supervisors = array();
        }

        return view('provider.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'provider_types' => $providerType,
            'organizations' =>$organizations,
            'selected_organization' => array(),
            'programs' => $programs,
            'selected_programs' => array(),
            'selected_supervisor' => array(),
            'participants' => User::get()->where('user_type_id',4)->pluck('full_name','id'),
            'supervisors' =>  $supervisors,
            'selected_supervisors' => array(),
            'org_id' => isset($orgID) ? $orgID : '',
            'pid' => isset($programID) ? $programID : ''
        ]);
    }

    public function store(ProviderRequest $request)
    {
        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
        }else {
            $request->request->add(['users' => ['image' => 'noImg.jpg'] + $request->users]);
        }

        // $password = Hash::make('123456');

        $request->request->add(['users' => ['user_type_id' => providerUserTypeId()] + $request->users]);

        $user = User::create($request->users);

        if(isset($request->user_set_password)){
            $user->notify(new SetPasswordNotification($user->email));
        }

        $organization = Organization::find($request->users['organization_id'])->addProvider();
        $request->request->add(['userDetail' => ['user_id' => $user->id,'created_by' => auth()->user()->id] + $request->userDetail]);
        $userDetail = $user->userDetail()->create($request->userDetail);

        $programs = array_combine(
            $request->user_programs['program_id'],
            array_fill(0, count($request->user_programs['program_id']), ['created_by' => auth()->user()->id])
        );

        //$user->programProvider()->sync($programs);

        // $request->request->add(['provider_supervisor' => ['created_by' => auth()->user()->id] + $request->provider_supervisor]);
        // $providerSupervisor = $user->providerSupervisor()->create($request->provider_supervisor);
        // User::find($providerSupervisor->supervisor_id)->userDetail->addProvider();

        $user->programProvider()->sync($request->user_programs['program_id']);
        if (!empty($request->provider_supervisor['supervisor_id']) && count($request->provider_supervisor['supervisor_id']) > 0) {
            foreach ($request->provider_supervisor['supervisor_id'] as $key => $value) {
               $providerSupervisor['provider_id'] = $user->id;
               $providerSupervisor['supervisor_id'] = explode(',',$value)[0];
               $providerSupervisor['program_id'] = explode(',',$value)[1];
               $providerSupervisor['created_by'] = Auth::id();
               ProviderSupervisor::create($providerSupervisor);

               $supervisor_id = explode(',',$value)[0];
               User::setProviderUserCount(explode(',',$value)[0]);
               User::setSupervisorUserCount($supervisor_id);
            }
        }

        if($user->id > 0){

            $request->event_id = 19;
            $request->related_id = $user->id;
            $request->email = $user->email;
            $request->desc = $user->full_name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Provider successfully added!',
                'redirect' => route('provider.edit', $user->id)
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'response' => 'Something went wrong!'
            ]);
        }
    }

    public function edit($id){
        $user = User::find($id);
        $supervisor = $user->providerSupervisor()->get()->first();
        $userDetail = $user->userDetail()->get()->where('user_id',$id)->first();
        $organizationType = ProviderType::where('id',$userDetail->provider_type_id)->first();
        $org_id = $organizationType->org_type_id;
        
        $orgID = $user->organization_id;
        $organization = Organization::whereId($orgID)->first();

        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
        }else if(Auth::user()->user_type_id == organizationAdminUserTypeId()){

            $user = Auth::user();
            $userDetail = $user->userDetail()->get()->where('user_id',$user->id)->first();
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
            $organizations = Organization::where('id',$user->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');

        }else{
            $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

            $providerType = ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id');
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');

        }
        $user = User::find($id);
        $programID = $user->programProvider()->select('program_id')->get()->map(function($program){
            return $program->program_id;
        })->toArray();

        foreach ($programID as $key => $value) {
            $supervisors[$key]['data'] = User::with('ProgramSupervisor')->whereHas('ProgramSupervisor',function($query) use ($value){ $query->where('program_id',$value); })->orderBy('first_name')->get();
            $supervisors[$key]['program_id'] = $value;
            $supervisors[$key]['program_name'] = Program::find($value)->name;
        }

        $participants = User::Where('user_type_id',participantUserTypeId())->whereHas('participantProvider',function($query) use ($id){
            $query->whereProviderId($id);
        })->orderBy('first_name','ASC')->get()->pluck('full_name','id');

        return view('provider.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'supervisors' => $supervisors,
            'participants' => $participants,
            'organizations' => $organizations,
            'organization' => $organization,
            'provider' => User::find($id),
            'provider_types' => $providerType,
            'providerDetail' => User::find($id)->userDetail,
            'id' => $id,
            'programs' => Organization::whereId($user->organization_id)->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id'),
            'selected_programs' => $programID,
            'selected_organization' => $user->organization_id,
            'selected_supervisor' => $user->providerSupervisor,
            'org_id' => '',
            'pid' => ''
        ]);
    }

    public function update($id, ProviderRequest $request){

        $user = User::find($id);

        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        } 

        $supervisor_id = $user->providerSupervisor()->first()->supervisor_id;

        if(isset($request->inactive_user) && $request->inactive_user == 1 && $user->is_active == 1){
            $request->request->add(['users' => ['is_active' => '0','inactive_date' => DBDateFormat(date('Y-m-d'))] + $request->users]);
            Goal::where('participant_id',$user->id)->where('status_id',goalActiveStatusId())->update([
                'status_id' => goalCloseStatusId()
            ]);
            $participants = User::whereHas('userDetail', function ($query) use($id) {
                $query->where('provider_id', $id);
            })->orderByName()->get();
            foreach ($participants as $key => $value) {
                User::setParticipantGoalCount($value->id);
                User::setParticipantAvgGoal($value->id);
            }

            User::setProviderGoalCount($id);
            foreach($user->providerSupervisor()->get() as $prov){
                User::setSupervisorGoalCount($prov->supervisor_id);
                User::setSupervisorAvgGoal($prov->supervisor_id);
            }
            User::setOrganizationGoalCount($user->organization_id);
            User::setProviderAvgGoal($id);
            User::setOrganizationAvgGoal($user->organization_id);
        }
        else{
            $request->request->add(['users' => ['is_active' => '1','inactive_date' => null] + $request->users]);
        }

        $old_user = $user;
        $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);
        $user->update($request->users);
        $user->programProvider()->detach();
        $programs = array_combine(
            $request->user_programs['program_id'],
            array_fill(0, count($request->user_programs['program_id']), ['last_modified_by' => auth()->user()->id])
        );

        $user->programProvider()->sync($programs);
        $user->providerSupervisor()->forceDelete();

        // $request->request->add(['provider_supervisor' => ['last_modified_by' => auth()->user()->id] + $request->provider_supervisor]);
        // $providerSupervisor = $user->providerSupervisor()->create($request->provider_supervisor);

        ProviderSupervisor::withoutGlobalScopes()->where('provider_id', $id)->forceDelete();
        if (!empty($request->provider_supervisor['supervisor_id']) && count($request->provider_supervisor['supervisor_id']) > 0) {
            foreach ($request->provider_supervisor['supervisor_id'] as $key => $value) {
                $providerSupervisor['provider_id'] = $id;
                $providerSupervisor['supervisor_id'] = explode(',',$value)[0];
                $providerSupervisor['program_id'] = explode(',',$value)[1];
                $providerSupervisor['created_by'] = Auth::id();
                $providerSupervisor['last_modified_by'] = Auth::id();
                ProviderSupervisor::create($providerSupervisor);
            }
        }

        $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id] + $request->userDetail]);
        $userDetail = $user->userDetail()->update($request->userDetail);

        //old user detail count
        User::setProviderUserCount($id);
        User::setOrganizationUserCount($old_user->organization_id);
        User::setOrganizationProviderCount($old_user->organization_id);

        foreach($old_user->providerSupervisor()->get() as $prov){
            $supervisor_id = $prov->supervisor_id;
            User::setSupervisorUserCount($supervisor_id);
            User::setSupervisorProviderCount($supervisor_id);
        }

        //new user detail count
        $user = User::find($user->id);
        $supervisor_id = $user->providerSupervisor()->first()->supervisor_id;
        User::setProviderUserCount($id);
        User::setOrganizationUserCount($user->organization_id);
        User::setOrganizationProviderCount($user->organization_id);

        foreach($user->providerSupervisor()->get() as $prov){
            $supervisor_id = $prov->supervisor_id;
            User::setSupervisorUserCount($supervisor_id);
            User::setSupervisorProviderCount($supervisor_id);
        }

        $request->event_id = 20;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->full_name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Provider successfully Updated!',
            'redirect' => route('provider.edit', $id)
        ]);
    }

    public function updateold1($id, ProviderRequest $request){

        $user = User::find($id);

        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        }

        $supervisor_id = $user->providerSupervisor()->first()->supervisor_id;

        if(isset($request->inactive_user) && $request->inactive_user == 1 && $user->is_active == 1){
            $request->request->add(['users' => ['is_active' => '0','inactive_date' => DBDateFormat(date('Y-m-d'))] + $request->users]);
            Goal::where('participant_id',$user->id)->where('status_id',goalActiveStatusId())->update([
                'status_id' => goalCloseStatusId()
            ]);
            $participants = User::whereHas('userDetail', function ($query) use($id) {
                $query->where('provider_id', $id);
            })->orderByName()->get();
            foreach ($participants as $key => $value) {
                User::setParticipantGoalCount($value->id);
                User::setParticipantAvgGoal($value->id);
            }

            User::setProviderGoalCount($id);
            foreach($user->providerSupervisor()->get() as $prov){
                User::setSupervisorGoalCount($prov->supervisor_id);
                User::setSupervisorAvgGoal($prov->supervisor_id);
            }
            User::setOrganizationGoalCount($user->organization_id);
            User::setProviderAvgGoal($id);
            User::setOrganizationAvgGoal($user->organization_id);
        }
        else{
            $request->request->add(['users' => ['is_active' => '1','inactive_date' => null] + $request->users]);
        }

        $old_user = $user;
        $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);
        $user->update($request->users);
        $user->programProvider()->detach();
        $programs = array_combine(
            $request->user_programs['program_id'],
            array_fill(0, count($request->user_programs['program_id']), ['last_modified_by' => auth()->user()->id])
        );

        $user->programProvider()->sync($programs);
        $user->providerSupervisor()->forceDelete();

        // $request->request->add(['provider_supervisor' => ['last_modified_by' => auth()->user()->id] + $request->provider_supervisor]);
        // $providerSupervisor = $user->providerSupervisor()->create($request->provider_supervisor);

        ProviderSupervisor::withoutGlobalScopes()->where('provider_id', $id)->forceDelete();
        if (!empty($request->provider_supervisor['supervisor_id']) && count($request->provider_supervisor['supervisor_id']) > 0) {
            foreach ($request->provider_supervisor['supervisor_id'] as $key => $value) {
                $providerSupervisor['provider_id'] = $id;
                $providerSupervisor['supervisor_id'] = explode(',',$value)[0];
                $providerSupervisor['program_id'] = explode(',',$value)[1];
                $providerSupervisor['created_by'] = Auth::id();
                $providerSupervisor['last_modified_by'] = Auth::id();
                ProviderSupervisor::create($providerSupervisor);
            }
        }

        $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id] + $request->userDetail]);
        $userDetail = $user->userDetail()->update($request->userDetail);

        //old user detail count
        User::setProviderUserCount($id);
        User::setOrganizationUserCount($old_user->organization_id);
        User::setOrganizationProviderCount($old_user->organization_id);

        foreach($old_user->providerSupervisor()->get() as $prov){
            $supervisor_id = $prov->supervisor_id;
            User::setSupervisorUserCount($supervisor_id);
            User::setSupervisorProviderCount($supervisor_id);
        }

        //new user detail count
        $user = User::find($user->id);
        $supervisor_id = $user->providerSupervisor()->first()->supervisor_id;
        User::setProviderUserCount($id);
        User::setOrganizationUserCount($user->organization_id);
        User::setOrganizationProviderCount($user->organization_id);

        foreach($user->providerSupervisor()->get() as $prov){
            $supervisor_id = $prov->supervisor_id;
            User::setSupervisorUserCount($supervisor_id);
            User::setSupervisorProviderCount($supervisor_id);
        }

        $request->event_id = 20;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->full_name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Provider successfully Updated!',
            'redirect' => route('provider.edit', $id)
        ]);
    }

    public function updateold($id, ProviderRequest $request){

        $user = User::find($id);

        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        }

        //$supervisor_id = $user->providerSupervisor()->first()->supervisor_id;

        if(isset($request->inactive_user) && $request->inactive_user == 1 && $user->is_active == 1){
            $request->request->add(['users' => ['is_active' => '0','inactive_date' => DBDateFormat(date('Y-m-d'))] + $request->users]);
            Goal::where('participant_id',$user->id)->where('status_id',goalActiveStatusId())->update([
                'status_id' => goalCloseStatusId()
            ]);
            $participants = User::whereHas('userDetail', function ($query) use($id) {
                $query->where('provider_id', $id);
            })->orderByName()->get();
            foreach ($participants as $key => $value) {
                User::setParticipantGoalCount($value->id);
                User::setParticipantAvgGoal($value->id);
            }

            foreach($user->providerSupervisor()->get() as $prov){
                User::setProviderGoalCount($prov->supervisor_id);
                $supervisor_id = User::find($prov->supervisor_id)->providerSupervisor()->first()->supervisor_id;
                User::setSupervisorGoalCount($supervisor_id);
                User::setProviderAvgGoal($prov->supervisor_id);
                User::setSupervisorAvgGoal($supervisor_id);
            }

            //User::setProviderGoalCount($id);
            //User::setSupervisorGoalCount($supervisor_id);
            User::setOrganizationGoalCount($user->organization_id);
            //User::setProviderAvgGoal($id);
            //User::setSupervisorAvgGoal($supervisor_id);
            User::setOrganizationAvgGoal($user->organization_id);
        }
        else{
            $request->request->add(['users' => ['is_active' => '1','inactive_date' => null] + $request->users]);
        }
        $old_user = $user;
        $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);
        $user->update($request->users);
        $user->programProvider()->detach();
        $programs = array_combine(
            $request->user_programs['program_id'],
            array_fill(0, count($request->user_programs['program_id']), ['last_modified_by' => auth()->user()->id])
        );
        $user->programProvider()->sync($programs);
        $user->providerSupervisor()->forceDelete();
        $request->request->add(['provider_supervisor' => ['last_modified_by' => auth()->user()->id] + $request->provider_supervisor]);

        //$providerSupervisor = $user->providerSupervisor()->create($request->provider_supervisor);

        ProviderSupervisor::withoutGlobalScopes()->where('provider_id', $id)->forceDelete();

        if (!empty($request->provider_supervisor['supervisor_id']) && count($request->provider_supervisor['supervisor_id']) > 0) {
            foreach ($request->provider_supervisor['supervisor_id'] as $key => $value) {
               $providerSupervisor['provider_id'] = $id;
               $providerSupervisor['supervisor_id'] = explode(',',$value)[0];
               $providerSupervisor['program_id'] = explode(',',$value)[1];
               $providerSupervisor['created_by'] = Auth::id();
               ProviderSupervisor::create($providerSupervisor);
            }
        }

        $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id] + $request->userDetail]);
        $userDetail = $user->userDetail()->update($request->userDetail);

        //old user detail count
        User::setProviderUserCount($id);
        User::setOrganizationUserCount($old_user->organization_id);
        User::setOrganizationProviderCount($old_user->organization_id);

        foreach($user->providerSupervisor()->get() as $prov){
            User::setSupervisorUserCount($prov->supervisor_id);
            User::setSupervisorProviderCount($prov->supervisor_id);
        }

        //new user detail count
        $user = User::find($user->id);

        User::setProviderUserCount($id);

        foreach($user->providerSupervisor()->get() as $prov){
            User::setSupervisorUserCount($prov->supervisor_id);
            $supervisor_id = User::find($prov->supervisor_id)->providerSupervisor()->first()->supervisor_id;
            User::setSupervisorProviderCount($prov->supervisor_id);
        }

        User::setOrganizationUserCount($user->organization_id);
        User::setOrganizationProviderCount($user->organization_id);

        return response()->json([
            'status'=> 'success',
            'response'=>'Provider successfully Updated!',
            'redirect' => route('provider.edit', $id)
        ]);
    }

    function getOrganizationPrograms(Request $request){

        if($request->get('organizationID')){

            $orgnizationType = OrganizationOrgType::select('org_type_id')->where('organization_id',$request->get('organizationID'))->get()->toArray();


            if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
                $programs = Program::whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');

                $providerTypes = ProviderType::whereIn('org_type_id',$orgnizationType)->orderBy('name','ASC')->get()->pluck('name', 'id');
            }elseif(Auth::user()->user_type_id == supervisorUserTypeId()){
                 $programs = Program::whereHas('ProgramSupervisors',function($query){
                      $query->where('supervisor_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');

                $providerTypes = ProviderType::whereIn('org_type_id',$orgnizationType)->orderBy('name','ASC')->get()->pluck('name', 'id');
            }else{
                   $programs =  Organization::whereId($request->get('organizationID'))->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id');

                if($request->get('orgID')){
                     $orgID  = $request->get('orgID');
                     $providerTypes = ProviderType::whereIn('organization_id',$orgID)->orderBy('name','ASC')->get()->pluck('name', 'id');
                 }else{
                    $providerTypes = ProviderType::whereIn('org_type_id',$orgnizationType)->orderBy('name','ASC')->get()->pluck('name', 'id');
                 }
            }
            //return view
            return response()->json([
                'status' => 'success',
                'response' => view('provider.select-organization-programs',['programs' => $programs
                ])->render(),
                'response1' => view('provider.select-provider-organizations',['providerTypes' => $providerTypes,'orgID' => $request->get('orgID')
                ])->render()
            ]);
        }
        return;
    }

    // function getProviderOrganizations(Request $request){

    //      if($request->get('providerTypeID')){

    //         $orgnizationType = ProviderType::where('id',$request->get('providerTypeID'))->first();
    //         $org_id = $orgnizationType->org_type_id;

    //         if(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == organizationAdminUserTypeId()){
    //             $organizations = Organization::whereHas('organizationOrgType',function($query) use ($org_id){
    //                   $query->whereOrgTypeId($org_id);
    //                     })->where('id',Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name', 'id');
    //         }
    //         else{
    //             if($request->get('orgID')){
    //                 $orgID  = $request->get('orgID');
    //                  $organizations = Organization::whereId($orgID)->orderBy('name','ASC')->get()->pluck('name', 'id');
    //              }else{
    //                  $organizations = Organization::whereHas('organizationOrgType',function($query) use ($org_id){
    //                   $query->whereOrgTypeId($org_id);
    //                     })->orderBy('name','ASC')->get()->pluck('name', 'id');
    //              }

    //         }

    //         //return view
    //         return response()->json([
    //             'status' => 'success',
    //             'response' => view('provider.select-provider-organizations',['organizations' => $organizations,'orgID' => $request->get('orgID')
    //             ])->render()
    //         ]);
    //     }
    //     return;
    // }

    function getProviderSupervisors(Request $request){
        
        if($request->get('programID')){
            //return view
            $pID = $request->get('programID');
            $orgID = $request->get('orgID');
            $organization = Organization::whereId($orgID)->first();

            //print_r($organization); exit;

            foreach ($pID as $key => $value) {
                if(Auth::user()->user_type_id == supervisorUserTypeId()){
                    $supervisors[$key]['data'] = User::with('ProgramSupervisor')->whereHas('ProgramSupervisor',function($query) use ($value){
                        $query->where('program_id',$value);
                        $query->where('supervisor_id',Auth::user()->id);
                    })->orderBy('first_name')->get();
                } else {
                    $supervisors[$key]['data'] = User::with('ProgramSupervisor')->whereHas('ProgramSupervisor',function($query) use ($value){
                        $query->where('program_id',$value);
                    })->orderBy('first_name')->get();
                }
                $supervisors[$key]['program_id'] = $value;
                $supervisors[$key]['program_name'] = Program::find($value)->name;
            }
            return response()->json([
                'status' => 'success',
                'response' => view('provider.select-provider-supervisors',['organization' => $organization, 'supervisors' => $supervisors
                ])->render()
            ]);
        }
        //return view
        return response()->json([
            'status' => 'success',
            'response' => ''
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
            echo json_encode("User already exist with this email.");
        }else{
            echo json_encode("true");
        }
    }
}
