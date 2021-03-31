<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Mail;
use App\Mail\EmailNotificationMail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function contactUsLanding(Request $request) {

        //print_r($request->contactus);exit;

        if(empty($request->contactus['name']) || empty($request->contactus['email']) || empty($request->contactus['phone']) || empty($request->contactus['message'])) {
            return response()->json([
                'status'=> 'error',
                'response'=>'All fields are required.'
            ]);
        } else {

            $fullname = $request->contactus['name'];
            $email = $request->contactus['email'];
            $phone = $request->contactus['phone'];
            $message = $request->contactus['message'];

            $user = array('full_name' => $fullname, 'email' => $email, 'phone' => $phone);

            $subject = config('constants.CONTACT_US_SUBJECT');

            Mail::to(config('constants.CONTACT_US_EMAIL'))->send(new EmailNotificationMail($subject, $message, (object) $user));

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
    }
}
