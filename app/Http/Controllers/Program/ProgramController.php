<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\State;
use App\Models\Organization;
use App\Http\Requests\Program\ProgramRequest;
use App\User;
use Validator;
use Auth;

use App\Events\GoalEvents;

class ProgramController extends Controller
{
    public function index()
    {
        return view('program.index');
    }

    public function list(Request $request)
    {
        return Program::getProgramsDt($request);
    }

   	public function create(Request $request)
    {
        if(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $organizations = Organization::where('id',Auth::user()->organization_id)->get()->pluck('name','id');
        }
        else{
            $organizations = Organization::get()->pluck('name','id');
        }

        $organization = Organization::get()->where('id',$request->org_id)->first();

        //print_r($program);exit;

        return view('program.add-edit')->with([
            'states' => State::get()->pluck('name', 'id'),
            'providers' => User::get()->where('user_type_id',providerUserTypeId())->pluck('full_name','id'),
            'participants' => User::get()->where('user_type_id',participantUserTypeId())->pluck('full_name','id'),
            'organizations' => $organizations,
            'organization' => $organization,
            'org_id' => $request->org_id,
            'organization_name' => Organization::get()->where('id',$request->org_id)->first()
        ]);
    }

    public function store(ProgramRequest $request)
    {
        if($request->file('program_image')){

            $image_name = uploadImage($request->file('program_image'), config('constants.program_image_storage_path'));

            $request->request->add(['program' => ['image' => $image_name,'country_id' => config('constants.DEFAULT_COUNTRY')] + $request->program]);
        } else {
            $request->request->add(['program' => ['image' => 'noImg.jpg','country_id' => config('constants.DEFAULT_COUNTRY')] + $request->program]);
        }

        $program = Program::create($request->program);

        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $program->programSupervisors()->sync(Auth::user()->id);
        }
        if($program->id > 0){

            $request->event_id = 17;
            $request->related_id = $program->id;
            $request->desc = $program->name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Program successfully added!',
                'redirect' => route('program.edit', $program->id)
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'response' => 'Something went wrong!'
            ]);
        }
    }

    public function edit($id)
    {
        $program = Program::find($id);

        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $organizations = Organization::where('id',Auth::user()->organization_id)->get()->pluck('name','id');
            $providers = User::whereHas('providersSupervisor',function($query) use ($id){
                $query->where('supervisor_id',Auth::user()->id);
            })->get()->pluck('full_name','id');
            $participants =  User::whereHas('participantProvider',function($query) use ($id){
                $query->whereHas('provider',function($query1) use ($id){
                 $query1->whereHas('providerSupervisor',function($query2) use ($id){
                     $query2->where('supervisor_id',Auth::user()->id);
                    });
                });
            })->get()->pluck('full_name','id');
        }else if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $organizations = Organization::where('id',Auth::user()->organization_id)->get()->pluck('name','id');
            $providers =  User::get()->where('user_type_id',providerUserTypeId())->where('organization_id',Auth::user()->organization_id)->pluck('full_name','id');
            $participants = User::get()->where('user_type_id',participantUserTypeId())->where('organization_id',Auth::user()->organization_id)->pluck('full_name','id');
        }  else{
            $organizations = Organization::get()->pluck('name','id');
            $providers = User::get()->where('user_type_id',providerUserTypeId())->pluck('full_name','id');
            $participants = User::get()->where('user_type_id',participantUserTypeId())->pluck('full_name','id');
        }       
        $organization = Organization::whereId($program->organization_id)->first();
        
        return view('program.add-edit')->with([
            'program' => $program,
            'states' => State::get()->pluck('name', 'id'),
            'providers' => $providers,
            'participants' => $participants,
            'organizations' => $organizations,
            'organization' => $organization,
            'id' => $id,
        ]);
    }

    public function update($id, ProgramRequest $request){

        $program = Program::find($id);
        if($request->file('program_image')){
            $image_name = uploadImage($request->file('program_image'), config('constants.program_image_storage_path'));

            $request->request->add(['program' => ['image' => $image_name] + $request->program]);
            $image = $program->getOriginal('image');
            deleteImage(config('constants.program_image_storage_path').config('constants.program_image_storage_path').'/'.$image);
        }

        $program->update($request->program);
           //  $user = Auth::user();
        if(Auth::user()->user_type_id == supervisorUserTypeId()){
                $program->programSupervisors()->detach();
                $program->programSupervisors()->sync(Auth::user()->id);
        }

        $request->event_id = 18;
        $request->related_id = $program->id;
        $request->desc = $program->name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Program successfully Updated!',
            'redirect' => route('program.edit', $id)
        ]);
    }

    public function validateEmail(Request $request)
    {

        if(empty($request->input('id'))){
            $validator = Validator::make($request->all(), [
                'email'  => 'required|unique:programs,name',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:programs,name,'.$request->get('id').',id',
            ]);
        }

        if ($validator->fails()) {
            echo json_encode("Program already exist with this name.");
        }else{
            echo json_encode("true");
        }
    }
}
