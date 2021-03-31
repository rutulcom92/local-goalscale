<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\User;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Program;
use App\Models\ProviderType;
use App\Http\Requests\Organization\OrganizationRequest;
use Validator;
use Auth;
use App\Events\GoalEvents;

class OrganizationController extends Controller
{
    public function index()
    {
        return view('organization.index')->with([
            'programs' => Program::get()->pluck('name','id'),
            'provider_types' => ProviderType::get()->pluck('name','id'),
        ]);
    }

    public function list(Request $request)
    {
        return Organization::getOrganizationDt($request);
    }

   	public function create()
    {
        return view('organization.add-edit')->with([
          // 'states' => State::get()->pluck('name', 'id'),
            'programs' => Program::get()->pluck('name','id'),
            'organization_types' => OrganizationType::orderBy('name','ASC')->get()->pluck('name','id'),
            'selected_org_types' => array(),
            'providers' => User::get()->where('user_type_id',providerUserTypeId())->pluck('full_name','id'),
            'participants' => User::get()->where('user_type_id',participantUserTypeId())->pluck('full_name','id'),
            'provider_types' => ProviderType::get()->pluck('name','id'),
        ]);
    }

    public function store(OrganizationRequest $request)
    {
    	if($request->file('organization_image')){

            $image_name = uploadImage($request->file('organization_image'), config('constants.organization_image_storage_path'));

            $request->request->add(['organization' => ['image' => $image_name] + $request->organization]);
        } else {
            $request->request->add(['organization' => ['image' => 'noImg.jpg'] + $request->organization]);
        }

        if($request->file('organization_image')){

            $image_name = uploadImage($request->file('organization_image'), config('constants.organization_logo_storage_path'));

            $request->request->add(['organization' => ['logo_image' => $image_name] + $request->organization]);
        } else {
            $request->request->add(['organization' => ['logo_image' => 'noImg.jpg'] + $request->organization]);
        }

        $organization = Organization::create($request->organization);

        $organization->organizationOrgType()->sync($request->organization_types);

        if($organization->id > 0){

            $request->event_id = 13;
            $request->related_id = $organization->id;
            $request->desc = $organization->name;
            event(new GoalEvents($request));

            return response()->json([
                'status'=> 'success',
                'response'=>'Organization successfully added!',
                'redirect' => route('organization.edit', $organization->id)
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
        $organization = Organization::find($id);
        $orgTypeID = $organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

        return view('organization.add-edit')->with([
            'organization' => $organization,
            //'states' => State::get()->pluck('name', 'id'),
            'programs' => Program::whereOrganizationId($id)->get()->pluck('name','id'),
            'organization_types' => OrganizationType::orderBy('name','ASC')->get()->pluck('name','id'),
            'selected_org_types' => $organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray(),

            'provider_types' => ProviderType::orderBy('name','ASC')->whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id'),
            'providers' => User::orderBy('first_name','ASC')->get()->where('user_type_id',providerUserTypeId())->where('organization_id', $id)->pluck('full_name','id'),
            'participants' => User::get()->where('user_type_id',participantUserTypeId())->pluck('full_name','id'),
            'id' => $id
        ]);
    }

    public function update($id, OrganizationRequest $request){

        $organization = Organization::find($id);
        if($request->file('organization_image')){
            $image_name = uploadImage($request->file('organization_image'), config('constants.organization_image_storage_path'));
            $request->request->add(['organization' => ['image' => $image_name] + $request->organization]);
            $image = $organization->getOriginal('image');
            deleteImage(config('constants.storage_path').config('constants.organization_image_storage_path').'/'.$image);
        }
        if($request->file('organization_logo')){
            $image_name = uploadImage($request->file('organization_logo'), config('constants.organization_logo_storage_path'));
            $request->request->add(['organization' => ['logo_image' => $image_name] + $request->organization]);
            $image = $organization->getOriginal('logo_image');
            deleteImage(config('constants.storage_path').config('constants.organization_logo_storage_path').'/'.$image);
        }
        $organization->update($request->organization);
        $organization->organizationOrgType()->detach();
        $organization->organizationOrgType()->sync($request->organization_types);

        $request->event_id = 14;
        $request->related_id = $id;
        $request->desc = $organization->name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Organization successfully Updated!',
            'redirect' => route('organization.edit', $id)
        ]);
    }

    public function validateEmail(Request $request)
    {
        if(empty($request->input('id'))){
            $validator = Validator::make($request->all(), [
                'email'  => 'required|unique:organizations,name',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:organizations,name,'.$request->get('id').',id',
            ]);
        }
        if($validator->fails()){
            echo json_encode("Organization already exist with this name.");
        }else{
            echo json_encode("true");
        }
    }
}
