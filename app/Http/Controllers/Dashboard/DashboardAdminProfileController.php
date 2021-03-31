<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Http\Requests\Dashboard\AdminProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Notifications\SetPasswordNotification;
use Auth;

class DashboardAdminProfileController extends Controller
{
    
    public function index(){
        $user = Auth::user();
        $userDetail = $user->userDetail()->get()->where('user_id',$user->id)->first();

        return view('dashboard.admin-profile')->with([
            'states' => State::get()->pluck('name', 'id'),
            'admin' => $user,
            'adminDetail' => $user->userDetail,
            'id' => $user->id,
        ]);
    }

    public function profileUpdate(AdminProfileRequest $request){
        
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
            'response'=>'Admin profile successfully Updated!'
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
            echo json_encode("Admin already exist with this email.");
        }else{
            echo json_encode("true");
        }
    }
}