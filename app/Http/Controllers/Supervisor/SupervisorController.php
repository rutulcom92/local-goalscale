<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Supervisor\SupervisorRequest;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;
use App\Events\GoalEvents;

class SupervisorController extends Controller
{
    public function index()
    {
        if(Auth::user()->user_type_id == organizationAdminUserTypeId()) {
            $user = Auth::user();
            $admin_id = Auth::user()->id;
            $organizations = Organization::orderBy('name','ASC')->whereId(Auth::user()->organization_id)->get()->pluck('name','id');
            $programs = Program::orderBy('name','ASC')->whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->get()->pluck('name', 'id');
        }else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = Program::orderBy('name','ASC')->get()->pluck('name','id');
        }

        return view('supervisor.index')->with([
            'organizations' =>  $organizations,
            'programs' =>  $programs,
        ]);
    }

    public function list(Request $request)
    {
        return User::getSupervisorDt($request);
    }

    public function create(Request $request)
    {

        $orgID = $request->get('id');

        if($orgID != ''){
            $organizations = Organization::whereId($orgID)->get()->pluck('name','id');
            $programs = Program::orderBy('name','ASC')->whereOrganizationId($orgID)->get()->pluck('name','id');
            $organization = Organization::whereId($orgID)->first();
        }
        else if(Auth::user()->user_type_id == organizationAdminUserTypeId()) {
            $organizations = Organization::orderBy('name','ASC')->whereId(Auth::user()->organization_id)->get()->pluck('name','id');
            $organization = Organization::whereId(Auth::user()->organization_id)->first();
            $programs = array();
        }else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
            $programs = array();
            $organization = '';
        }

        

        return view('supervisor.add-edit')->with([
            'organizations' => $organizations,
            'organization' => $organization,
            'states' => State::get()->pluck('name', 'id'),
            'programs' => $programs,
            'participants' => User::whereUserTypeId(participantUserTypeId())->with('userDetail')->get()->pluck('full name' ,'id'),
            'providers' => User::whereUserTypeId(providerUserTypeId())->with('userDetail')->get()->pluck('full name' ,'id'),
            'selected_programs' => array(),
            'org_id' => isset($orgID) ? $orgID : ''
        ]);
    }

    public function store(SupervisorRequest $request)
    {
        if($request->file('user_image')){

            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));

            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
        } else {
            $request->request->add(['users' => ['image' => 'noImg.jpg'] + $request->users]);
        }

        // $password = Hash::make('123456');

        $request->request->add(['users' => ['user_type_id'=>supervisorUserTypeId()] + $request->users]);

        $user = User::create($request->users);

        if(isset($request->user_set_password)){
            $user->notify(new SetPasswordNotification($user->email));
        }

        $request->request->add(['userDetail' => ['user_id' => $user->id,'created_by' => auth()->user()->id]]);

        $userDetail = $user->userDetail()->create($request->userDetail);

        $user->programSupervisor()->sync($request->user_programs['program_id']);

        if($user->id > 0){

            $request->event_id = 15;
            $request->related_id = $user->id;
            $request->email = $user->email;
            $request->desc = $user->full_name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Supervisor successfully added!',
                'redirect' => route('supervisor.edit', $user->id)
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'response' => 'Something went wrong!'
            ]);
        }
    }

    public function edit($id){

        if(Auth::user()->user_type_id == organizationAdminUserTypeId()) {
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name','ASC')->get()->pluck('name','id');
        }else{
            $organizations = Organization::orderBy('name','ASC')->get()->pluck('name','id');
        }
        
        $user = User::find($id);

        $organization = Organization::whereId($user->organization_id)->first();
        
        //print_r($organization->program_label); exit;

        // User::whereUserTypeId(providerUserTypeId())->with('userDetail')->whereHas('ProviderSupervisor',function($query) use($id){
        // $query->where('supervisor_id',$id)
        return view('supervisor.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'participants' =>  User::whereHas('participantProvider',function($query) use ($id){
                $query->whereHas('provider',function($query1) use ($id){
                 $query1->whereHas('providerSupervisor',function($query2) use ($id){
                     $query2->where('supervisor_id',$id);
                    });
                });
            })->orderBy('first_name','ASC')->get()->pluck('full name' ,'id'),
            'providers' =>   User::whereHas('providersSupervisor',function($query) use ($id){
                $query->where('supervisor_id',$id);
            })->orderBy('first_name','ASC')->get()->pluck('full name' ,'id'),
            'organizations' => $organizations,
            'organization' => $organization,
            'supervisor' => $user,
            'supervisorDetail' => $user->userDetail,
            'id' => $id,
            'org_id' => '',
            'programs' => Organization::whereId($user->organization_id)->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id'),
            'selected_programs' => $user->programSupervisor()->select('program_id')->get()->map(function($program){
                return $program->program_id;
            })->toArray(),
        ]);
    }

    public function update($id, SupervisorRequest $request){

        $user = User::find($id);

        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        }

        if(isset($request->inactive_user) && $request->inactive_user == 1){
            $request->request->add(['users' => ['is_active' => '0','inactive_date' => DBDateFormat(date('Y-m-d'))] + $request->users]);
        }
        else{
            $request->request->add(['users' => ['is_active' => '1','inactive_date' => null] + $request->users]);
        }

        $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);

        $user->update($request->users);

        $user->programSupervisor()->detach();
        $user->programSupervisor()->sync($request->user_programs['program_id']);

        $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id]]);

        $userDetail = $user->userDetail()->update($request->userDetail);
        // return redirect()->back()->withSuccess('IT WORKS!');

        $request->event_id = 16;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->full_name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Supervisor successfully Updated!',
            'redirect' => route('supervisor.edit', $id)
        ]);
    }

    function getOrganizationPrograms(Request $request){

        if($request->get('organizationID')){
            if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $user = Auth::user();
            $programs = Program::whereHas('ProgramOrgAdmins',function($query){
                      $query->where('admin_id',Auth::user()->id);
                        })->orderBy('name','ASC')->get()->pluck('name', 'id');
            }
            else{
                $programs = Organization::whereId($request->get('organizationID'))->first()->programs()->orderBy('name','ASC')->get()->pluck('name', 'id');
            }
            //return view
            return response()->json([
                'status' => 'success',
                'response' => view('supervisor.select-organization-programs',['programs' => $programs
           ])->render()
        ]);
        }
        return;
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
