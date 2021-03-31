<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserType;
use App\Models\State;
use App\Models\Organization;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SetPasswordNotification;

use App\Events\GoalEvents;

class UserController extends Controller
{
    public function index()
    {

    }

    public static function import(Request $request){
        if ($request->ajax()) {
            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv","xlsx","xls");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){

                // Check file size
                if($fileSize <= $maxFileSize){

                    // File upload location
                    $location = 'uploads';

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);

                    // Reading file
                    $file = fopen($filepath,"r");

                    $importData_arr = array();
                    $i = 0;

                    $importData_arr = $fields = array();
                    $response['error'] = '';
                    $i = 0;
                    $handle = @fopen($filepath, "r");
                    if ($handle) {
                        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                            if (empty($fields)) {
                                $fields = $row;
                                continue;
                            }
                           // echo '<br>id = <pre>';print_r(array_filter($row));echo '</pre>';
                            $row = array_filter($row);
                            foreach ($row as $k=>$value) {

                                if (array_key_exists($k,$fields))
                                {
                                    $valuef = $fields[$k];
                                    if (mb_detect_encoding($fields[$k]) === 'UTF-8') {
                                        // delete possible BOM
                                        // not all UTF-8 files start with these three bytes
                                        $valuef = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $fields[$k]);
                                    }
                                    if(!empty($value) && in_array($valuef,array('first_name', 'last_name', 'user_type', 'email', 'phone', 'address', 'city', 'state', 'zip', 'organization'))) {
                                        $importData_arr[$i][$valuef] = $value;
                                    } else {
                                        $response['error'] .= 'User data is missing at row no. '.$i.'<br>';
                                        continue;
                                    }
                                } else {
                                    continue;
                                }
                            }
                            $i++;
                        }
                        if (!feof($handle)) {
                            echo "Error: unexpected fgets() fail\n";
                        }
                        fclose($handle);
                       // echo 'importData_arr = <pre>';print_r($importData_arr);echo '</pre>';
                        $row = 0;

                        foreach($importData_arr as $importData){

                            if(!empty($importData['first_name']) && !empty($importData['last_name']) && !empty($importData['user_type']) && !empty($importData['email']) && !empty($importData['phone']) && !empty($importData['address']) && !empty($importData['city']) && !empty($importData['state']) && !empty($importData['zip']) && !empty($importData['organization'])) {
                                $row++;
                            } else {
                                $response['error'] .= 'User data is missing at row no. '.$row.'<br>';
                                continue;
                            }
                        }

                        $total_records = count($importData_arr);

                        if($total_records == 0) {
                            $response['error'] = 'Incorrect or No records found in your file.';
                            return response()->json($response);
                        }
                        //echo $total_records . ' | ' . $row;

                        if(!empty($importData_arr)) {
                            $returnHTML = view('user.importdata')->with('importdata', $importData_arr)->render();
                            return response()->json(array('success' => true, 'html'=>$returnHTML));
                        }
                    }
                    else {
                        $response['error'] = 'Something went wrong. Please try again later.';
                        return response()->json($response);
                    }

                } else {
                    $response['error'] = 'File too large. File must be less than 2MB.';
                    return response()->json($response);
                }

            } else {
                $response['error'] = 'Sorry, File extension is not allowed. (Allowed file extensions : .'.implode(', .',$valid_extension).')';
                return response()->json($response);
            }
        }
    }

    public function importPost(Request $request)
    {
        if ($request->ajax()) {
            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv","xlsx",".xls");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){

                // Check file size
                if($fileSize <= $maxFileSize){

                    // File upload location
                    $location = 'uploads';

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);

                    $importData_arr = $fields = array();
                    $i = 0;
                    $handle = @fopen($filepath, "r");
                    if ($handle) {
                        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                            if (empty($fields)) {
                                $fields = $row;
                                continue;
                            }
                           // echo 'fields = <pre>';print_r($fields);echo '</pre>';
                            foreach ($row as $k=>$value) {
                                $valuef = $fields[$k];
                                if (mb_detect_encoding($fields[$k]) === 'UTF-8') {
                                    // delete possible BOM
                                    // not all UTF-8 files start with these three bytes
                                    $valuef = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $fields[$k]);
                                }
                                $importData_arr[$i][$valuef] = $value;
                            }
                            $i++;
                        }
                        if (!feof($handle)) {
                            echo "Error: unexpected fgets() fail\n";
                        }
                        fclose($handle);

                        $total_records = count($importData_arr);
                        $processed = 0;
                        $userCount = 0;
                        $row = 0;
                        $tagErrors = array();
                        $providerAssignedErrors = array();
                        $participentsErrors = array();
                        $providerExistErrors = array();
                        $rowErrors = array();
                        $response['notice'] = '';
                        $response['errors'] = '';

                        foreach($importData_arr as $importData){
                            $row++;
                            if(!empty($importData['first_name']) && !empty($importData['last_name']) && !empty($importData['user_type']) && !empty($importData['email']) && !empty($importData['phone']) && !empty($importData['address']) && !empty($importData['city']) && !empty($importData['state']) && !empty($importData['zip']) && !empty($importData['organization'])) {

                                $userData = User::getUserDataByEmail($importData['email']);

                                $user_type_id = UserType::whereName($importData['user_type'])->get()->pluck('id')->first();

                                //echo 'user_type = <pre>';print_r($user_type);echo '</pre>';

                                $organization_id = Organization::whereName($importData['organization'])->get()->pluck('id')->first();

                                $state_id = State::whereName($importData['state'])->get()->pluck('id')->first();

                                //echo 'organizations = <pre>';print_r($organizations);echo '</pre>';

                                if(empty($userData)) {

                                    $insertData = array(
                                        "first_name"        => $importData['first_name'],
                                        "last_name"         => $importData['last_name'],
                                        "user_type_id"      => $user_type_id,
                                        'organization_id'   => $organization_id,
                                        'email'             => $importData['email'],
                                        'phone'             => $importData['phone'],
                                        "address"           => $importData['address'],
                                        "city"              => $importData['city'],
                                        'state_id'          => $state_id,
                                        'zip'               => $importData['zip'],
                                        'created_at'        => date('Y-m-d H:i:s')
                                    );

                                    // $request->request->add(['users' => ['user_type_id'=> participantUserTypeId()] + $request->users]);
                                    $user = User::create($insertData);
                                    $userId = $user->getAttributes()['id'];

                                    if(isset($userId) && $userId != ""){
                                        $userCount++;
                                    }

                                    $response['success'] = $userCount.' out of '.$total_records.' users imported successfully.';

                                    

                                } else {
                                    $participantExistErrors[] = $row;
                                    $response['errors'] .= 'Email already exist at row no. '.$row.'<br>';
                                    continue;
                                }
                            } else {
                                $rowErrors[] = $row;
                                $response['errors'] .= 'User data is missing at row no. '.$row.'<br>';
                                continue;
                            }
                        }
                        $request->event_id = 23;
                        $request->desc = $response['success'];
                        event(new GoalEvents($request));
                        return response()->json($response);
                    }
                    else {
                        $response['error'] = 'Something went wrong. Please try again later.';
                        return response()->json($response);
                    }

                } else {
                    $response['error'] = 'File too large. File must be less than 2MB.';
                    return response()->json($response);
                }

            } else {
                $response['error'] = 'Sorry, File extension is not allowed. (Allowed file extensions : .'.implode(', .',$valid_extension).')';
                return response()->json($response);
            }
        }
    }


}
