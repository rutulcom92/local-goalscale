<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use App\Models\ProgramSupervisor;
use App\Models\ProviderSupervisor;
use App\Http\Requests\Provider\ProviderProfileRequest;
use App\Models\ProviderType;
use App\Models\OrganizationOrgType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;

class ProviderProfileController extends Controller
{
    
    public function index(){
        $user = Auth::user();
        $userDetail = $user->userDetail()->get()->where('user_id',$user->id)->first();
        $orgTypeID = $user->organization->organizationOrgType()->select('org_type_id')->get()->map(function($org){
                return $org->org_type_id;
            })->toArray();

        return view('provider.profile')->with([
            'states' => State::get()->pluck('name', 'id'),
            'provider' => $user,
            'provider_types' => ProviderType::whereIn('org_type_id',$orgTypeID)->get()->pluck('name','id'),
            'providerDetail' => $user->userDetail,
            'id' => $user->id,
        ]);
    }

    public function profileUpdate(ProviderProfileRequest $request){
        
        $user = Auth::user();

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

        $user->update($request->users);
        $userDetail = $user->userDetail()->update($request->userDetail);

        //new user detail count
        $user = User::find($user->id);
        $supervisor_id = $user->providerSupervisor()->first()->supervisor_id;
        User::setProviderUserCount($user->id);
        User::setSupervisorUserCount($supervisor_id);
        User::setOrganizationUserCount($user->organization_id);
        User::setSupervisorProviderCount($supervisor_id);
        User::setOrganizationProviderCount($user->organization_id);

        return response()->json([
            'status'=> 'success',
            'response'=>'Provider profile successfully Updated!'
        ]);
    }
}