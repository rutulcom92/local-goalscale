<?php

namespace App\Http\Controllers\Goal;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Requests\Goals\GoalRequest;
use App\Models\OrganizationType;
use App\Models\Goal;
use App\Models\GoalActivity;
use App\Models\GoalScale;
use App\Models\Program;
use App\Models\Organization;
use App\Models\Tag;
use App\User;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PDF;

class GoalController extends Controller
{
    public function index()
    {
        if (Auth::user()->isSuperAdmin()) {
            $participants = User::whereUserTypeId(participantUserTypeId())->orderBy('first_name')->get();
            $organizations = organization::orderBy('name')->get()->pluck('name','id');
        } else
         {
            $participants = User::whereUserTypeId(participantUserTypeId())->whereOrganizationId(Auth::user()->organization_id)->orderBy('first_name','ASC')->get();
            $organizations = organization::whereId(Auth::user()->organization_id)->orderBy('name')->get()->pluck('name','id');
        }

        return view('goal.index')->with([
            'tags' => Tag::orderBy('tag', 'ASC')->get(),
            'participants' => $participants,
            'organizations' => $organizations
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $goalFilters = [];

            if (Auth::user()->isSuperAdmin()) {
                $goalFilters['participantsIdArray'] = (!empty($request->participant) ? [$request->participant] : []);
            } else if (Auth::user()->isSupervisor()) {
                $goalFilters['providersIdArray'] = Auth::user()->supervisorProviders()->get()->pluck('id')->toArray();
                 $goalFilters['participantsIdArray'] = (!empty($request->participant) ? [$request->participant] : []);
            } else if (Auth::user()->isProvider()) {

                if (!empty($request->participant)) {
                    $goalFilters['participantsIdArray'] = [$request->participant];
                } else {
                    $goalFilters['participantsIdArray'] = User::whereUserTypeId(participantUserTypeId())->whereOrganizationId(Auth::user()->organization_id)->get()->pluck('id')->toArray();
                }
            } else if (Auth::user()->isParticipant()) {

                if (!empty($request->participant)) {
                    $goalFilters['participantsIdArray'] = [$request->participant];
                } else {
                    $goalFilters['participantsIdArray'] = User::whereId(Auth::id())->get()->pluck('id')->toArray();
                }
            }

            $goalFilters['tag'] = $request->tag;
            $goalFilters['organization'] = $request->organization;
            return Goal::goalsDt($goalFilters);
        } else {
            abort(500);
        }
    }

    public function importxx()
    {
        return view('goal.import');
    }

    //public static function importConfirm(Request $request){
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
            $valid_extension = array("csv");

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
                    
                    // while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    //     $num = count($filedata );
                        
                    //     // Skip first row (Remove below comment if you want to skip the first row)
                    //     // if($i == 0){
                    //     //     $i++;
                    //     //     continue; 
                    //     // }
                    //     if (empty($fields)) {
                    //         $fields = $row;
                    //         continue;
                    //     }
                    //     //echo 'filedata = <pre>';print_r($filedata);echo '</pre>';
                    //     //if (!empty($filedata)) {
                    //         for ($c=0; $c < $num; $c++) {
                    //             if(!empty($filedata[$c])) {
                    //                 $valuef = $filedata[$c];
                    //                 if (mb_detect_encoding($fields[$k]) === 'UTF-8') {
                    //                     // delete possible BOM
                    //                     // not all UTF-8 files start with these three bytes
                    //                     $valuef = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $fields[$k]);
                    //                 }
                    //                 $importData_arr[$i][] = $valuef;
                    //             }
                    //         }
                    //         $i++;
                    //     //}
                    // }
                    // fclose($file);

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
                        
                        if(!empty($importData_arr)) {
                            $returnHTML = view('goal.importdata')->with('importdata', $importData_arr)->render();
                            return response()->json(array('success' => true, 'html'=>$returnHTML));
                        }
                    }
                    exit;
                    if (($handle = fopen($filepath, "r")) !== FALSE) {
                        //echo '<table class="tbl">'; 

                        
                        
                        // while(($data = fgetcsv($handle, 1000, ",")) !== false)
                        // {  
                        //     // You need to grab the header values on first iteration
                        //     if ($counter == 0) {
                        //         // store them in an array
                        //         $headerValues = $data;
                        //         // increment counter
                        //         $counter++;                  
                        //     }                
                
                        //     $col    = count($data); 
                        //     echo '<tr>';
                        //     for ($c=0; $c < $col; $c++) {
                        //         // grab column name here
                        //         $headerName = $headerValues[$c]; 
                        //         $cell   = $data[$c];
                        //         $colnum = $c + 1;
                        //         if( $row == 0)
                        //         {                    
                        //             echo "<td  style='text-transform:uppercase;'><br><br>". 
                        //                     "<b>{$headerName}</b></td>"; 
                        //         }
                        //         else
                        //         { 
                        //             echo "<td>{$cell} = {$headerName}</td>";  //{$row} = {$colnum} 
                        //         } 
                        //     }
                        //     echo '</tr>'; 
                        //     $row++; 
                
                        // }  
                
                        // echo '</table>';
                    }
                    exit;
                } 
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
            $valid_extension = array("csv");

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
                    // $file = fopen($filepath,"r");

                    // $importData_arr = array();
                    // $i = 0;
                    
                    // while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    //     $num = count($filedata );
                        
                    //     // Skip first row (Remove below comment if you want to skip the first row)
                    //     if($i == 0){
                    //         $i++;
                    //         continue; 
                    //     }
                    //     //echo 'filedata = <pre>';print_r($filedata);echo '</pre>';
                    //     //if (!empty($filedata)) {
                    //         for ($c=0; $c < $num; $c++) {
                    //             if(!empty($filedata[$c])) {
                    //                 $importData_arr[$i][] = $filedata[$c];
                    //             }
                    //         }
                    //         $i++;
                    //     //}
                    // }
                    // fclose($file);

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

                       // echo 'importData_arrayss = <pre>';print_r($importData_arr);echo '</pre>'; //exit;
                        // Insert to MySQL database
                        foreach($importData_arr as $importData){
                            // echo 'importData = <pre>';print_r($importData);echo '</pre>'; 

                            $insertData = array(
                                            "name"=>$importData['goal_name'],
                                            "participant_id"=>$importData['participant_id'],
                                            "provider_id"=>$importData['provider_id'],
                                            'created_by' => Auth::id(),
                                            'status_id' => 1
                                        );
                            //echo 'insertData = <pre>';print_r($insertData);echo '</pre>';
                            $goal = Goal::create($insertData);
                            for ($c=0; $c < 5; $c++) {
                                if(!empty($importData['scaling'.$c])) {
                                    $goal->scales()->create([
                                        'value' => strval($c),
                                        'description' => strval($importData['scaling'.$c]),
                                        'created_by' => Auth::id(),
                                    ]);
                                }
                            }

                            $Tags = $importData['tags'];
                            $TagsArr = explode(',', $Tags);
                            
                            if (!empty($TagsArr) && count($TagsArr) > 0) {
                                foreach($TagsArr as $Tag) {
                                    //echo "<br>Tag = ".$Tag;
                                    $TagData = Goal::getTagDataByTagName($Tag);
                                    $goal->tags()->attach($TagData->id, [
                                        'created_by' => Auth::id(),
                                    ]);
                                }
                            }
                            $response['success'] = true;
                            $response['msg'] = 'Goals imported successfully.';
                            return response()->json($response);
                            //echo "<br>GoalID = ". $GoalID = Goal::insertGoalData($insertData);
                        }
                        exit;

                        Session::flash('message','Import Successful.');
                    }

                    
                } else {
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }
        }
    }

    public function create()
    {
        $participants = [];
        if (Auth::user()->isProvider()) {
            $participants = User::whereUserTypeId(participantUserTypeId())->whereHas('participantProvider',function($query){
                $query->where('provider_id',Auth::user()->id);
            })->orderByName()->get();
        }
        
        return view('goal.create.form')->with([
            'orgTypes' => OrganizationType::orderBy('name', 'ASC')->get(),
            'providers' => Auth::user()->getProviders(),
            'participants' => $participants
        ]);
    }
    
    public function getProviderParticipants(Request $request)
    {
        if (Auth::user()->isParticipant()) {
            $participants = User::whereUserTypeId(participantUserTypeId())->whereHas('participantProvider',function($query){
                $query->where('provider_id',Auth::user()->id);
            })->orderByName()->get();
        }
        else{
            $participants = User::whereHas('participantProvider', function (Builder $query) use($request) {
                $query->where('provider_id', $request->provider_id);
            })->orderByName()->get();
        }
        return response()->json([
            'status' => 'success',
            'participants' => $participants,
        ]);
    }

    public function store(GoalRequest $request)
    {
        $goal = Goal::create($request->goalData);

        $goal->addParticipantGoal();
        $goal->addProviderGoal();
        $goal->addSupervisorGoal();
        $goal->addOrganizationGoal();

        $goal->setParticipantAvgGoal();
        $goal->setProviderAvgGoal();
        $goal->setSupervisorAvgGoal();
        $goal->setOrganizationAvgGoal();
        
        if (!empty($request->goal['scale']) && count($request->goal['scale']) > 0) {

            foreach ($request->goal['scale'] as $key => $value) {

                $goal->scales()->create([
                    'value' => strval($key),
                    'description' => strval($value),
                    'created_by' => Auth::id(),
                ]);
            }
        }

        if (!empty($request->goal['tags']) && count($request->goal['tags']) > 0) {

            foreach ($request->goal['tags'] as $key => $value) {
                $goal->tags()->attach($value, [
                    'created_by' => Auth::id(),
                ]);
            }
        }
        return redirect(route('goal.index'))->with('success', 'Goal successfully added!');
    }

    public function edit($id)
    {
        return view('goal.view.form',[
            'goal_detail' => Goal::find($id)
        ]);
    }

    public function view($id)
    {
        return view('goal.view.form',[
            'goal_detail' => Goal::find($id)
        ]);
    }

    public function getGraphDetails(Request $request){
        $goal = Goal::find($request->goalID);
        $graphData = array();

        $yaxis = array(0,1,2,3,4);
        $categories[] = date('m/d/y, h:i A',strtotime($goal->goal_start_date));
        $data = array();
        $data['y'] = 0;
        $data['color'] = '#FA6400';
        $data['name'] = 'Goal Start';
        $data['toolInfo'] = '';
        $graphData[] = $data;

        if(!empty($goal->activities)){
            foreach ($goal->activities()->where('parent_activity_id',0)->orderBy('id')->get() as $activity) {
                $categories[] = $activity->date_of_activity;
                $data = array();
                $data['name'] = $activity->owner->full_name;
                $data['toolInfo'] = view('goal.edit._goal-progress-tooltip',[
                        'activity' => $activity,
                        'goal' => $goal
                ])->render();
                if($activity->owner->user_type_id == 4){
                    $participant_activity = $goal->activities()->where('created_by',$goal->participant_id)->where('id',$activity->id)->orderBY('id')->first();
                    $data['color'] = '#2C82BE';
                    $data['y'] =  !empty($participant_activity) ? (int) $participant_activity->activity_ranking : 0;
                }
                else{
                    $provider_activity = $goal->activities()->where('created_by','!=',$goal->participant_id)->where('id',$activity->id)->orderBY('id')->first();
                    $data['color'] = '#FA6400';
                    $data['y'] = !empty($provider_activity) ? (int) $provider_activity->activity_ranking : 0;
                }
                $graphData[] = $data;
            }
        }

        //return view
        return response()->json([
            'status' => 'success',
            'graphData' => $graphData,
            'categories' => $categories,
            'yaxis' => $yaxis
        ]);
    }

    public function update($id,GoalRequest $request){
        $goal = Goal::find($id);
        
        $last_activity = $goal->activities()->orderBy('created_at','DESC')->first();

        // if(!empty($last_activity)){
        //     $goal_change = $last_activity->activity_ranking;
        // }
        // else{
            $goal_change = $request->goal['activity_ranking'];
       // }

        $goal->update(['goal_change' => $goal_change,'goal_closed_date' => date('Y-m-d H:i:s')]);

        $activity = $goal->activities()->create($request->goal);
        if($request->hasFile('activity_files')){   
            foreach($request->file('activity_files') as $image)
            {         
                $image_name = uploadImage($image ,config('constants.goal_activity_storage_path'));                
                $activity->attachments()->create(['name' => $image_name,'created_by' => $request->user()->id]);
            }
        }

        $goal = Goal::find($id);
        $goal->setParticipantAvgGoal();
        $goal->setProviderAvgGoal();
        $goal->setSupervisorAvgGoal();
        $goal->setOrganizationAvgGoal();

        return response()->json([
            'status'=> 'success',
            'response'=>'Activity successfully added!',
            'last_id' => (Goal::find($id)->activities()->where('parent_activity_id',0)->orderBy('id','DESC')->limit(5)->get()->max('id'))+1
        ]);
    }

    public function getActivities(Request $request){

        //return view
        return response()->json([
            'status' => 'success',
            'response' => view('goal.edit._goal-get-activities',['activities' => Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()
            ])->render(),
            'last_id' => (Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()->count() == 5 ) ? Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()->min('id') : null
        ]);
    }

    public function getActivityReplay(Request $request){
        //return view
        return response()->json([
            'status' => 'success',
            'response' => view('goal.edit._goal-get-activity-replay',['activity' => GoalActivity::where('id',strval($request->id))->first()
            ])->render()
        ]);
    }

    public function activityReplay($id,Request $request){
        $goal_activity = GoalActivity::find($id);
        $goal = $goal_activity->goal;
        $activity = $goal->activities()->create([
            'update_text' => $request->update_text,
            'goal_id' => $goal->id,
            'activity_ranking' => '0',
            'participant_id' => Auth::user()->id,
            'created_by' => Auth::user()->id,
            'date_of_activity' => DBDateTimeFormat(date('Y-m-d H:i:s')),
            'parent_activity_id' => $id
        ]);
        if($request->hasFile('activity_files')){   
            foreach($request->file('activity_files') as $image)
            {         
                $image_name = uploadImage($image ,config('constants.goal_activity_storage_path'));                
                $activity->attachments()->create(['name' => $image_name,'created_by' => $request->user()->id]);
            }
        }
         return response()->json([
            'status'=> 'success',
            'response'=>'Replay successfully added!',
             'last_id' => ($goal->activities()->where('parent_activity_id',0)->orderBy('id','DESC')->limit(5)->get()->max('id'))+1
        ]);
    }

    public function closeStatus($id,Request $request){
        $goal = Goal::whereId($id)->first();
        $goal->update(['status_id'=> goalCloseStatusId()]);

        $goal->setParticipantGoalCount();
        $goal->setProviderGoalCount();
        $goal->setSupervisorGoalCount();
        $goal->setOrganizationGoalCount();
        
        $goal->setParticipantAvgGoal();
        $goal->setProviderAvgGoal();
        $goal->setSupervisorAvgGoal();
        $goal->setOrganizationAvgGoal();

        return response()->json([
            'status'=> 'success',
            'response'=>'Goal successfully closed!',
        ]);
    }

    public function goalDetailExport($id,Request $request){

        $goal = Goal::find($id);
       

        $data = [
            'goal_detail' =>  Goal::find($id),
            'goalScales' => GoalScale::whereGoalId($id)->get(),
            'activities' => $goal->activities()->where('parent_activity_id',0)->orderBy('id','DESC')->get(),
            'goalGraph' => $request->get('goalgrp')
        ];
        
        $footer = view('goal.goal-pdf-footer')->render();
        $header = view('goal.goal-pdf-header', $data)->render();

        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'encoding' => 'UTF-8',
           // 'footer-spacing'   => 1
            //'footer-center' => 'Page [page] of [toPage]',
        ];
       
        $pdf = PDF::loadView('goal.goal-detail-export', $data);
        //pr($pdf); die;
        $pdf->setOptions($options);
        // $pdf->setOption('footer-center', 'Page [page]');
        // $pdf->setOption("footer-right", "[page] of [topage]");
        // $pdf->setOption("footer-font-size",10);
        // $pdf->setOption("footer-line",true);
        $pdf->setOption('enable-javascript', true);
        // $pdf->setOption('javascript-delay', 500);
        $pdf->setOption('footer-spacing',2);
        // $pdf->setOption('enable-smart-shrinking', true);
        // $pdf->setOption('no-stop-slow-scripts', true);
        // $pdf->setOptions(['images' => true,'isRemoteEnabled'=> TRUE]);
         
        return $pdf->download("goal-detail-".time().".pdf");
    }
}