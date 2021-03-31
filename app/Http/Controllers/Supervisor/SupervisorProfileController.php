<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Supervisor\SupervisorProfileRequest;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;

class SupervisorProfileController extends Controller
{
    public function index(){

        $user = Auth::user();
        return view('supervisor.profile')->with([
            'states' => State::get()->pluck('name', 'id'),
            'supervisor' => $user,
            'supervisorDetail' => $user->userDetail,
            'id' => $user->id,
        ]);
    }

    public function profileUpdate(SupervisorProfileRequest $request){
        
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
        
        return response()->json([
            'status'=> 'success',
            'response'=>'Supervisor profile successfully Updated!'
        ]);
    }

}