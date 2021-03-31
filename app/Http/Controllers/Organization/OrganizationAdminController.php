<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Organization;
use App\Models\Program;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Organization\OrganizationAdminRequest;
use App\Notifications\SetPasswordNotification;
use Validator;

use App\Events\GoalEvents;

class OrganizationAdminController extends Controller
{
    public function list($id,Request $request)
    {
        return User::getOrganizationAdminDt($id,$request);
    }

    public function create(Request $request)
    {

        $orgID = $request->get('id');
        if($orgID != ''){
            $organizations = Organization::whereId($orgID)->get()->pluck('name','id');
            $programs = Program::whereOrganizationId($orgID)->get()->pluck('name','id');
        }
        else{
            $organizations = Organization::get()->pluck('name','id');
            $programs = Program::get()->pluck('name','id');
        }

        return view('organization.partials._add-edit-admin-section')->with([
            'states' => State::get()->pluck('name', 'id'),
            'organizations' => $organizations,
            'programs' => $programs,
            'selected_programs' => array()
        ]);
    }

    public function store(OrganizationAdminRequest $request)
    {
        if($request->file('user_image')){

            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));

            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
        } else {
            $request->request->add(['users' => ['image' => 'noImg.jpg'] + $request->users]);
        }

        // $password = Hash::make('123456');

        $request->request->add(['users' => ['user_type_id' => organizationAdminUserTypeId()] + $request->users]);

        $user = User::create($request->users);

        if(isset($request->user_set_password)){
            $user->notify(new SetPasswordNotification($user->email));
        }

        $request->request->add(['userDetail' => ['user_id' => $user->id,'created_by' => auth()->user()->id]]);

        $userDetail = $user->userDetail()->create($request->userDetail);

        $user->programOrgAdmin()->sync($request->user_programs['program_id']);

        if($user->id > 0){

            $request->event_id = 24;
            $request->related_id = $user->id;
            $request->email = $user->email;
            $request->desc = $user->full_name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Supervisor successfully added!'
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

        return view('organization.partials._add-edit-admin-section')->with([
            'states' => State::get()->pluck('name', 'id'),
            'organizations' => Organization::get()->pluck('name','id'),
            'orgAdmin' => $user,
            'orgAdminDetail' => $user->userDetail,
            'id' => $id,
            'programs' => Organization::whereId($user->organization_id)->first()->programs()->get()->pluck('name', 'id'),
            'selected_programs' => $user->programOrgAdmin()->select('program_id')->get()->map(function($program){
                return $program->program_id;
            })->toArray()
        ]);
    }

    public function update($id, OrganizationAdminRequest $request){

        $user = User::find($id);

        if($request->file('user_image')){
            $image_name = uploadImage($request->file('user_image'), config('constants.user_profile_storage_path'));
            $request->request->add(['users' => ['image' => $image_name] + $request->users]);
            $image = $user->getOriginal('image');
            deleteImage(config('constants.user_profile_storage_path').config('constants.user_profile_storage_path').'/'.$image);
        }

        $request->request->add(['users' => ['last_modified_by' => auth()->user()->id] + $request->users]);

        $user->update($request->users);

        $user->programOrgAdmin()->detach();
        $user->programOrgAdmin()->sync($request->user_programs['program_id']);

        $request->request->add(['userDetail' => ['user_id' => $id,'last_modified_by' => auth()->user()->id]]);

        $userDetail = $user->userDetail()->update($request->userDetail);

        $request->event_id = 25;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->full_name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Supervisor successfully Updated!'
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
