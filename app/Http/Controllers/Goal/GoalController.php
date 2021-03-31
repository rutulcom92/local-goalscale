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
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use App\Events\GoalEvents;

class GoalController extends Controller
{
    public function index()
    {
        //event(new GoalEvents($request));

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
            $imagePath = $file->getPathName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // 5MB in Bytes
            $maxFileSize = 5242880;

            // Check file mimeType
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if(isset($filename) && in_array($mimeType, $file_mimes)) {

                // Check file size
                if($fileSize <= $maxFileSize){

                    if('csv' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    } else if('xlsx' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    } else if('xls' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    }

                    $spreadsheet = $reader->load($imagePath);

                    $sheetData = $spreadsheet->getActiveSheet()->toArray();

                    $importData_arr = $fields = array();
                    $response['error'] = '';
                    $i = 0;

                    foreach ($sheetData as $kk=>$row) {
                        $row = array_filter($row);

                        if (empty($fields)) {
                            $fields = $row;
                            continue;
                        }

                        foreach ($row as $k=>$value) {

                            if (array_key_exists($k,$fields))
                            {
                                $valuef = $fields[$k];
                                if (mb_detect_encoding($fields[$k]) === 'UTF-8') {
                                    $valuef = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $fields[$k]);
                                }
                                if(!empty($value) && in_array($valuef,array('goal_name', 'participant_email', 'provider_email', 'scaling0', 'scaling1', 'scaling2', 'scaling3', 'scaling4', 'tags'))) {
                                    $importData_arr[$i][$valuef] = $value;
                                } else {
                                    $response['error'] .= 'Goal data is missing at row no. '.$i.'<br>';
                                    continue;
                                }
                            } else {
                                continue;
                            }
                        }
                        $i++;
                    }

                    //echo 'importData_arr = <pre>';print_r($importData_arr);echo '</pre>';
                    $row = 0;

                    foreach($importData_arr as $importData){

                        if(!empty($importData['goal_name']) && !empty($importData['participant_email']) && !empty($importData['provider_email']) && !empty($importData['scaling0']) && !empty($importData['scaling1']) && !empty($importData['scaling2']) && !empty($importData['scaling3']) && !empty($importData['scaling4'])) {
                            $row++;
                        } else {
                            $response['error'] .= 'Goal data is missing at row no. '.$row.'<br>';
                            continue;
                        }
                    }

                    $total_records = count($importData_arr);

                    if($total_records == 0) {
                        $response['error'] = 'Incorrect or No records found in your file.';
                        return response()->json($response);
                    }

                    if(!empty($importData_arr)) {
                        $returnHTML = view('goal.importdata')->with('importdata', $importData_arr)->render();
                        return response()->json(array('success' => true, 'html'=>$returnHTML));
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
            $imagePath = $file->getPathName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // 5MB in Bytes
            $maxFileSize = 5242880;

            // Check file mimeType
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if(isset($filename) && in_array($mimeType, $file_mimes)) {

                // Check file size
                if($fileSize <= $maxFileSize){

                    if('csv' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    } else if('xlsx' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    } else if('xls' == $extension) {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    }

                    $spreadsheet = $reader->load($imagePath);

                    $sheetData = $spreadsheet->getActiveSheet()->toArray();

                    $importData_arr = $fields = array();
                    $response['error'] = '';
                    $i = 0;

                    foreach ($sheetData as $kk=>$row) {
                        $row = array_filter($row);

                        if (empty($fields)) {
                            $fields = $row;
                            continue;
                        }

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

                    $total_records = count($importData_arr);
                    $processed = 0;
                    $goalCount = 0;
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
                        if(!empty($importData['goal_name']) && !empty($importData['participant_email']) && !empty($importData['provider_email']) && !empty($importData['scaling0']) && !empty($importData['scaling1']) && !empty($importData['scaling2']) && !empty($importData['scaling3']) && !empty($importData['scaling4'])) {

                            $Participant = Goal::getUserDataByEmail($importData['participant_email']);
                            $Provider = Goal::getUserDataByEmail($importData['provider_email']);

                            $providersIdArray = Auth::user()->supervisorProviders()->get()->pluck('id')->toArray();

                            if(!empty($Participant->id)) {

                                if(!empty($Provider->id)) {

                                    $ProviderId = $Provider->id;

                                    $participantsIdArray = User::Where('user_type_id',participantUserTypeId())->whereHas('participantProvider',function($query) use ($ProviderId){
                                        $query->whereProviderId($ProviderId);
                                    })->get()->pluck('id')->toArray();

                                    if(in_array($Participant->id, $participantsIdArray)) {

                                        if(Auth::user()->isSuperAdmin() || in_array($Provider->id, $providersIdArray)) {

                                            $insertData = array(
                                                "name"=>$importData['goal_name'],
                                                "participant_id"=>$Participant->id,
                                                "provider_id"=>$Provider->id,
                                                'created_by' => Auth::id(),
                                                'status_id' => 1,
                                                'created_at' => date('Y-m-d H:i:s')
                                            );

                                            $goal = Goal::create($insertData);
                                            $goalId = $goal->getAttributes()['id'];

                                            if(isset($goalId) && $goalId != ""){
                                                $goalCount++;
                                                $eventMsg = $goalCount.' out of '.$total_records.' Goals imported successfully.';

                                                $request->event_id = 1;
                                                $request->desc = $eventMsg;
                                                event(new GoalEvents($request));
                                            }

                                            for ($c=0; $c < 5; $c++) {
                                                if(!empty($importData['scaling'.$c])) {
                                                    $goal->scales()->create([
                                                        'value' => strval($c),
                                                        'description' => strval($importData['scaling'.$c]),
                                                        'created_by' => Auth::id(),
                                                        'created_at' => date('Y-m-d H:i:s')
                                                    ]);
                                                }
                                            }

                                            $Tags = $importData['tags'];
                                            $TagsArr = explode(',', $Tags);
                                            $tagsArrs = array();
                                            if (!empty($TagsArr) && count($TagsArr) > 0) {
                                                foreach($TagsArr as $Tag) {
                                                    if(!empty($Tag)) {
                                                        $TagData = Goal::getTagDataByTagName($Tag);
                                                        if(!empty($TagData)) {
                                                            $goal->tags()->attach($TagData->id, [
                                                                'created_by' => Auth::id(),
                                                                'created_at' => date('Y-m-d H:i:s')
                                                            ]);
                                                            $TagDataE[] = $row;
                                                        } else {
                                                            $tagsArrs[] = $Tag;
                                                        }
                                                    }
                                                }
                                                if(!empty($tagsArrs)) {
                                                    $tagNames = implode(', ', $tagsArrs);
                                                    $tagErrors[] = $row;
                                                    $response['notice'] .= 'Goals imported : Some tags ('.$tagNames.') are not found from row no. '.$row.'<br>';
                                                    continue;
                                                }
                                            }
                                            $response['success'] = $goalCount.' out of '.$total_records.' Goals imported successfully.';

                                            $request->event_id = 1;
                                            $request->desc = $response['success'];
                                            event(new GoalEvents($request));

                                        } else {
                                            $providerAssignedErrors[] = $row;
                                            $response['errors'] .= 'Supervisor does not have access to provider at row no. '.$row.'<br>';
                                            continue;
                                        }
                                    } else {
                                        $participantsErrors[] = $row;
                                        $response['errors'] .= 'Provider does not have access to participant at row no. '.$row.'<br>';
                                        continue;
                                    }
                                } else {
                                    $providerExistErrors[] = $row;
                                    $response['errors'] .= 'Provider not found at row no. '.$row.'<br>';
                                    continue;
                                }
                            } else {
                                $participantExistErrors[] = $row;
                                $response['errors'] .= 'Participant not found at row no. '.$row.'<br>';
                                continue;
                            }
                        } else {
                            $rowErrors[] = $row;
                            $response['errors'] .= 'Goal data is missing at row no. '.$row.'<br>';
                            continue;
                        }
                    }
                    return response()->json($response);

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

    public function progress($export_type, $done, $total, $size = 30)
    {
        static $start_time;
        // if we go over our bound, just ignore it
        if ($done > $total) return;
        if (empty($start_time)) $start_time = time();
        $now = time();
        $perc = (float)($done / $total);
        $bar = floor($perc * $size);
        $status_bar = "\r$export_type [";
        $status_bar .= str_repeat("=", $bar);
        if ($bar < $size) {
            $status_bar .= ">";
            $status_bar .= str_repeat(" ", $size - $bar);
        } else {
            $status_bar .= "=";
        }
        $disp = number_format($perc * 100, 0);
        $status_bar .= "] $disp%  $done/$total";
        $rate = ($now - $start_time) / $done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);
        $elapsed = $now - $start_time;
        $status_bar .= " remaining: " . number_format($eta) . " sec.  elapsed: " . number_format($elapsed) . " sec.";
        echo "$status_bar  ";
        flush();
        // when done, send a newline
        if ($done == $total) {
            echo "\n";
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
        $goalId = $goal->getAttributes()['id'];

        $request->event_id = 3;
        $request->related_id = $goalId;
        $request->desc = $goal->getAttributes()['name'];
        event(new GoalEvents($request));

        return redirect(route('goal.index'))->with('success', 'Goal successfully added!');
    }

    public function updateGoal($id, GoalRequest $request)
    {
        $goal = Goal::find($id);

        //echo '<br>id = <pre>';print_r($id);echo '</pre>';
        //echo '<br>goalData = <pre>';print_r($request->goal['scale']);//echo '</pre>'; exit;
        $goal->update($request->goalData);

        if (!empty($request->goal['scale']) && count($request->goal['scale']) > 0) {

            foreach ($request->goal['scale'] as $key => $value) {

                $scale = Goal::getScaleDataByScaleValue($id,$key);
                //echo '<br>scalesss = <pre>';print_r($scale);
                if(!empty($scale)) {
                    //echo '<br>'.$id.'|'.$key;
                    $scale = Goal::updateScaleValue($id,$key,strval($value));
                    // $goal->scales()->update(['goal_id' => $id,'value' => strval($scale->value)],[
                    //     'value' => strval($key),
                    //     'description' => strval($value),
                    //     'last_modified_by' => Auth::id()
                    // ]);
                } else {
                    $goal->scales()->create([
                        'value' => strval($key),
                        'description' => strval($value),
                        'created_by' => Auth::id()
                    ]);
                }

            }
            //exit;
        }

        if (!empty($request->goal['tags']) && count($request->goal['tags']) > 0) {

            foreach ($request->goal['tags'] as $key => $value) {
                $goal->tags()->attach($value, [
                    'created_by' => Auth::id(),
                ]);
            }
        }

        $request->event_id = 2;
        $request->related_id = $id;
        $request->desc = $goal->name;
        event(new GoalEvents($request));

        return redirect(route('goal.index'))->with('success', 'Goal successfully updated!');
    }

    public function edit($id)
    {
        $participants = [];
        if (Auth::user()->isProvider()) {
            $participants = User::whereUserTypeId(participantUserTypeId())->whereHas('participantProvider',function($query){
                $query->where('provider_id',Auth::user()->id);
            })->orderByName()->get();
        }

        // $goal = Goal::find($id);
        // $activity = $goal->activities()->get();
        // echo '<br>activity count = <pre>';print_r($activity->count());echo '</pre>';
        // echo '<br>activity = <pre>';print_r($activity);echo '</pre>';

        return view('goal.edit.form')->with([
            'orgTypes' => OrganizationType::orderBy('name', 'ASC')->get(),
            'providers' => Auth::user()->getProviders(),
            'participants' => $participants,
            'goal_detail' => Goal::find($id)
        ]);
    }

    public function view($id, Request $request)
    {
        $activity = Goal::find($id)->activities()->where('parent_activity_id',0)->where('id','<',strval(540))->orderBy('id','DESC')->limit(5)->toSql();
        //echo '<br>activity count = <pre>';print_r($activity->count());echo '</pre>';
        //echo '<br>activity = <pre>';print_r($activity);echo '</pre>';
        // DB::enableQueryLog();
        // print_r(DB::getQueryLog());
        $goal = Goal::find($id);
        $goalId = $id;

        $request->event_id = 12;
        $request->related_id = $goalId;
        $request->desc = $goal->name;
        event(new GoalEvents($request));

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
                $data['toolInfo'] = view('goal.view._goal-progress-tooltip',[
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

        $request->event_id = 26;
        $request->related_id = $id;
        $request->desc = $request->user()->full_name . ' rated <b>' . $goal_change . '</b> to goal name with ' . $goal->name;
        event(new GoalEvents($request));

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
            'response' => view('goal.view._goal-get-activities',['activities' => Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()
            ])->render(),
            'last_id' => (Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()->count() == 5 ) ? Goal::find($request->goalID)->activities()->where('parent_activity_id',0)->where('id','<',strval($request->lastActivityID))->orderBy('id','DESC')->limit(5)->get()->min('id') : null
        ]);
    }

    public function getActivityReplay(Request $request){
        //return view
        return response()->json([
            'status' => 'success',
            'response' => view('goal.view._goal-get-activity-replay',['activity' => GoalActivity::where('id',strval($request->id))->first()
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

        $request->event_id = 26;
        $request->related_id = $goal->id;
        $request->desc = Auth::user()->full_name . ' replied on goal activity of ' . $goal->name;
        event(new GoalEvents($request));

        return response()->json([
            'status'=> 'success',
            'response'=>'Reply successfully added!',
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

        $request->event_id = 7;
        $request->related_id = $id;
        $request->desc = $goal->name;
        event(new GoalEvents($request));

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
