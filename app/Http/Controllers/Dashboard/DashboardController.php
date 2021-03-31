<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\DashboardRequest;
use Mail;
use Auth;
use App\Models\SiteContent;
use App\Mail\EmailNotificationMail;
use App\User;

class DashboardController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        // pr(\Artisan::call('migrate'));exit();
        return view('dashboard.index');
    }

    public function welcomeToGoalCreate(){
        return response()->json([
            'status' => 'success',
            'response' => view('dashboard.add-welcome-content')->render()
        ]);
    }

    public function welcomeToGoalStore(Request $request){
        $welcome_content = SiteContent::where('reference_key','welcome_to_goal_attainment_scaling')->first();
        if(!empty($welcome_content)){
            $welcome_content->update(['content' => $request->sitecontent['content']]);
        }
        else{
            $request->request->add(['sitecontent' => ['last_modified_by' => Auth::user()->id] + $request->sitecontent]);
            SiteContent::create($request->sitecontent);
        }

        $welcome_heading = SiteContent::where('reference_key','welcome_heading')->first();
        if(!empty($welcome_heading)){
            $welcome_heading->update(['content' => $request->welcomeHeading['content']]);
        }
        else{
            $request->request->add(['welcomeHeading' => ['last_modified_by' => Auth::user()->id] + $request->welcomeHeading]);
            SiteContent::create($request->welcomeHeading);
        }
        
        return response()->json([
            'status'=> 'success',
            'response'=>'Welcome content successfully changed!'
        ]);
    }

    public function aboutUsCreate(){
        return response()->json([
            'status' => 'success',
            'response' => view('dashboard.add-about-us-content')->render()
        ]);
    }

    public function aboutUsStore(Request $request){
        $aboutus_content = SiteContent::where('reference_key',$request->sitecontent['reference_key'])->first();
        if(!empty($aboutus_content)){
            $aboutus_content->update(['content' => $request->sitecontent['content']]);
        }
        else{
            $request->request->add(['sitecontent' => ['last_modified_by' => Auth::user()->id] + $request->sitecontent]);
            SiteContent::create($request->sitecontent);
        }

        $aboutUsHeading = SiteContent::where('reference_key',$request->aboutUsHeading['reference_key'])->first();
        if(!empty($aboutUsHeading)){
            $aboutUsHeading->update(['content' => $request->aboutUsHeading['content']]);
        }
        else{
            $request->request->add(['aboutUsHeading' => ['last_modified_by' => Auth::user()->id] + $request->aboutUsHeading]);
            SiteContent::create($request->aboutUsHeading);
        }

        if($request->file('about_us_image')){
            $image_name = uploadImage($request->file('about_us_image'), config('constants.about_us_image_storage_path'));
            $aboutUsImage = SiteContent::where('reference_key',$request->aboutUsImage['reference_key'])->first();            
            if(!empty($aboutUsImage)){
                $aboutUsImage->update(['content' => $image_name]);
            }
            else{
                $request->request->add(['aboutUsImage' => ['last_modified_by' => Auth::user()->id,'content' => $image_name] + $request->aboutUsImage]);
                SiteContent::create($request->aboutUsImage);
            }
        }

        $aboutUsImageContent = SiteContent::where('reference_key',$request->aboutUsImageContent['reference_key'])->first();
        if(!empty($aboutUsImageContent)){
            $aboutUsImageContent->update(['content' => $request->aboutUsImageContent['content']]);
        }
        else{
            $request->request->add(['aboutUsImageContent' => ['last_modified_by' => Auth::user()->id] + $request->aboutUsImageContent]);
            SiteContent::create($request->aboutUsImageContent);
        }        

        return response()->json([
            'status'=> 'success',
            'response'=>'About Us content successfully changed!'
        ]);
    }

    public function contactUs(DashboardRequest $request) {  
        $org_name = !empty(Auth::user()->organization) ? Auth::user()->organization->name : '';
        $subject = config('constants.CONTACT_US_SUBJECT').' '.$org_name;
        Mail::to(config('constants.CONTACT_US_EMAIL'))->send(new EmailNotificationMail($subject,$request->contactus['messages'], Auth::user()));

        if (Mail::failures()) {
           return response()->json([
                'status'=> 'error',
                'response'=>'Sorry! Something went wrong. Please try again latter.'
            ]);
        }else{
           return response()->json([
                'status'=> 'success',
                'response'=>'Message successfully sent!'
            ]);
        }
    }

    public function imageUpload($id,Request $request) {  
        $user = User::find($id);
    
        if($request->file('logo_image')){
            $image_name = uploadImage($request->file('logo_image'), config('constants.user_logo_storage_path'));
            $request->request->add(['users' => ['logo_image' => $image_name]]);
            $image = $user->getOriginal('logo_image');
            deleteImage(config('constants.user_logo_storage_path').config('constants.user_logo_storage_path').'/'.$image);
        }

        $request->request->add(['users' => ['last_modified_by' => $user->id] + $request->users]);

        $user->update($request->users);

        return response()->json([
            'status'=> 'success',
            'response'=>'Logo successfully Updated!'
        ]);
    }
}