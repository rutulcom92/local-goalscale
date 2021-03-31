<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\SiteContent;
use App\Models\Goal;
use App\Models\GoalTag;
use App\Models\GoalActivity;
use App\Models\UserDetail;
use App\Models\ProgramParticipant;
use App\User;
use App\Models\Program;

function pr($array){
	echo "<pre>";
	return print_r($array);
	echo "</pre>";
}

function numFormatWithDecimal($num){
    return number_format($num, 2);
}

function activeStatusId(){
	return '1';
}

function superAdminUserTypeId() {
	return 1;
}

function supervisorUserTypeId() {
	return 2;
}

function providerUserTypeId() {
	return 3;
}

function participantUserTypeId() {
	return 4;
}

function organizationAdminUserTypeId() {
	return 5;
}

function goalActiveStatusId() {
	return 1;
}

function goalPendingApprovalStatusId() {
	return 3;
}

function goalCloseStatusId() {
	return 2;
}

function getUserStatus($status){
	if($status == 1){
		return 'Active';
	}else{
		return 'Inactive';
	}
}

function pageTitle($title) {
	if (is_array($title)) {
		return config('app.name', 'WMU - Goal Attainment Scaling').' | '.implode(' | ', $title);
	}else{
		return config('app.name', 'WMU - Goal Attainment Scaling').' | '.$title;
	}
}

function goalScale($key = null) {

	$scale = [];

	for ($i = 4; $i >= 0; $i--) {
		$scale[$i] = $i;
	}

	if (!empty($key)) {
		return $scale[$key];
	}
	return $scale;
}

function apiReponse($response, $status){
	return response()->json($response, $status);
}

function mdyDateFormate($date){
	return date('m/d/Y', strtotime($date));
}

function DBDateFormat($date){
	return date('Y-m-d', strtotime($date));
}

function DBDateTimeFormat($date){
	return date('Y-m-d H:i:s', strtotime($date));
}

function lastLoginDisplay($dateTime){
	return date('m/d/Y @h:i A', strtotime($dateTime));
}

function lastUpdateDisplay($date){
	return date('M d, Y', strtotime($date));
}

function uploadImage($requestImage, $folderName) {
    $originalName = time().'_'.$requestImage->getClientOriginalName();
    $path = $requestImage->storeAs($folderName, $originalName);
    return $originalName;
}

function deleteImage($image)
{
	if(File::exists($image)) {
	    File::delete($image);
        return true;
    }
    return false;
}

function getSiteConfig($key){
	$siteContent = SiteContent::where('reference_key', $key)->first();
	if(!empty($siteContent)){
		return $siteContent->content;
	}
	return ;
}

function maskPhoneInUsFormat($phone){
    if(empty($phone)){
        return "";
    }
    $number = preg_replace("/[^\d]/","",$phone);
    $length = strlen($number);
    if($length == 10) {
        return preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $number);
    }
    return $number;
}

function calculateProviderUserCount($provider_id){
  	return User::whereHas('participantProvider',function($query) use($provider_id){
  		$query->where('provider_id',$provider_id);
  	})->whereIsActive(activeStatusId())->count();
}

function calculateSupervisorUserCount($provider_ids){
  	return User::whereHas('participantProvider',function($query) use($provider_ids){
  		$query->whereIn('provider_id',$provider_ids);
  	})->whereIsActive(activeStatusId())->count();
}

function calculateSupervisorProviderCount($provider_ids){
  	return User::whereIn('id',$provider_ids)->whereIsActive(activeStatusId())->count();
}

function calculateParticipantGoalCount($participant_id){
  return (Goal::whereParticipantId($participant_id)->whereStatusId(goalActiveStatusId())->count());
}

function calculateProviderGoalCount($provider_id){
  return (Goal::whereProviderId($provider_id)->whereStatusId(goalActiveStatusId())->count());
}

function calculateSupervisorGoalCount($provider_ids){
  return (Goal::whereIn('provider_id',$provider_ids)->whereStatusId(goalActiveStatusId())->count());
}

function calculateParticipantAvgGoal($participant_id){
	// if(Goal::whereParticipantId($participant_id)->whereStatusId(goalActiveStatusId())->count() == 0){
	// 	return 0;
	// }
	 //  return (Goal::whereParticipantId($participant_id)->whereStatusId(goalActiveStatusId())->sum('goal_change') / Goal::whereParticipantId($participant_id)->whereStatusId(goalActiveStatusId())->count());
	if(calculateNumOfParticipantsOpenGoals($participant_id) == 0){
        return 0;
    }
    return (calculateSumOfParticipantsLatestActivity($participant_id) / calculateNumOfParticipantsOpenGoals($participant_id));
}

function calculateProviderAvgGoal($provider_id){
	// if(Goal::whereProviderId($provider_id)->whereStatusId(goalActiveStatusId())->count() == 0){
	// 	return 0;
	// }
 //   return (Goal::whereProviderId($provider_id)->whereStatusId(goalActiveStatusId())->sum('goal_change') / Goal::whereProviderId($provider_id)->whereStatusId(goalActiveStatusId())->count());
	if(calculateNumOfProviderOpenGoals($provider_id) == 0){
        return 0;
    }
    return (calculateSumOfProviderLatestActivity($provider_id) / calculateNumOfProviderOpenGoals($provider_id));
}

function calculateSupervisorAvgGoal($provider_ids){
	// if(Goal::whereIn('provider_id',$provider_ids)->whereStatusId(goalActiveStatusId())->count() == 0){
	// 	return 0;
	// }
	//  return (Goal::whereIn('provider_id',$provider_ids)->whereStatusId(goalActiveStatusId())->sum('goal_change') / Goal::whereIn('provider_id',$provider_ids)->whereStatusId(goalActiveStatusId())->count());
	if(calculateNumOfSupervisorOpenGoals($provider_ids) == 0){
        return 0;
    }
    return (calculateSumOfSupervisorLatestActivity($provider_ids) / calculateNumOfSupervisorOpenGoals($provider_ids));
}

function calculateProgramParticipantGoals($program_id){

	 return '(SELECT sum(ud.num_users_goals) as goal_count
	 			FROM
	 			'.with(new ProgramParticipant)->getTable().' AS pp
	 			LEFT JOIN
	 				'.with(new UserDetail)->getTable().' AS ud
	 					ON
	 						ud.user_id = pp.participant_id
	 			LEFT JOIN
	 					'.with(new User)->getTable().' As u
	 					ON
	 						u.id = ud.user_id
	 			WHERE
	 				u.is_active = "1" AND pp.program_id = "'.$program_id.'")';
}

function calculateProgramParticipants($program_id){

	 return '(SELECT count(*) as participant_count
	 			FROM
	 				'.with(new ProgramParticipant)->getTable().' AS pp
	 			LEFT JOIN
	 				'.with(new User)->getTable().' As u
	 			ON
	 				u.id = pp.participant_id
	 			WHERE
	 				u.is_active = "1" AND pp.program_id =  "'.$program_id.'")';
}


function calculateSumOfParticipantsLatestActivity($participant_id){
	$query = "(SELECT
				  SUM(CAST(CAST(goal_activity.activity_ranking AS CHAR) AS SIGNED)) AS
				  	participant_sum
				FROM
				  ".with(new GoalActivity)->getTable()."
				  LEFT JOIN ".with(new Goal)->getTable()."
				    ON `goal_activity`.`goal_id` = `goals`.`id`
				   LEFT JOIN ".with(new User)->getTable()."
				   ON goals.`participant_id` = users.`id`
				WHERE goal_activity.id = (SELECT MAX(id) FROM goal_activity WHERE goal_id =  goals.id AND parent_activity_id = 0 )
				AND goals.participant_id = ".$participant_id."
				AND goals.`status_id` = 1
				AND (users.is_active  = 1 OR users.is_active = '1'))";
	$result = DB::select($query);
    return $result[0]->participant_sum;
}

function calculateNumOfParticipantsOpenGoals($participant_id){
	$query = "(SELECT
				  COUNT(*) as user_count
				FROM
				  ".with(new Goal)->getTable()."
				  LEFT JOIN ".with(new User)->getTable()."
				    ON users.id = goals.participant_id
				WHERE participant_id = ".$participant_id."
				  AND (users.is_active  = 1 OR users.is_active = '1')
				  AND goals.status_id = 1)";
	$result = DB::select($query);
    return $result[0]->user_count;
}

function calculateSumOfProviderLatestActivity($provider_id){
	$query = "(SELECT
				  SUM(CAST(CAST(goal_activity.activity_ranking AS CHAR) AS SIGNED)) AS
				  	provider_sum
				FROM
				  ".with(new GoalActivity)->getTable()."
				  LEFT JOIN ".with(new Goal)->getTable()."
				    ON `goal_activity`.`goal_id` = `goals`.`id`
				   LEFT JOIN ".with(new User)->getTable()."
				   ON goals.`provider_id` = users.`id`
				WHERE goal_activity.id = (SELECT MAX(id) FROM goal_activity WHERE goal_id =  goals.id AND parent_activity_id = 0 )
				AND goals.provider_id = ".$provider_id."
				AND goals.`status_id` = 1
				AND (users.is_active  = 1 OR users.is_active = '1'))";
	$result = DB::select($query);
    return $result[0]->provider_sum;
}

function calculateNumOfProviderOpenGoals($provider_id){
	$query = "(SELECT
				  COUNT(*) as user_count
				FROM
				  ".with(new Goal)->getTable()."
				  LEFT JOIN ".with(new User)->getTable()."
				    ON users.id = goals.provider_id
				WHERE provider_id = ".$provider_id."
				  AND (users.is_active  = 1 OR users.is_active = '1')
				  AND goals.status_id = 1)";
	$result = DB::select($query);
    return $result[0]->user_count;
}

function calculateSumOfSupervisorLatestActivity($provider_ids){
	$provider_ids = implode(',', $provider_ids);
	$query = "(SELECT
				  SUM(CAST(CAST(goal_activity.activity_ranking AS CHAR) AS SIGNED)) AS
				  user_sum
				FROM
				  ".with(new GoalActivity)->getTable()."
				  LEFT JOIN ".with(new Goal)->getTable()."
				    ON `goal_activity`.`goal_id` = `goals`.`id`
				   LEFT JOIN ".with(new User)->getTable()."
				   ON goals.`provider_id` = users.`id`
				WHERE goal_activity.id = (SELECT MAX(id) FROM goal_activity WHERE goal_id =  goals.id AND parent_activity_id = 0 )
				AND goals.provider_id IN (".$provider_ids.")
				AND goals.`status_id` = 1
				AND (users.is_active  = 1 OR users.is_active = '1'))";
	$result = DB::select($query);
    return $result[0]->user_sum;
}

function calculateNumOfSupervisorOpenGoals($provider_ids){
	$provider_ids = implode(',', $provider_ids);
	$query = "(SELECT
				  COUNT(*) as user_count
				FROM
				  ".with(new Goal)->getTable()."
				  LEFT JOIN ".with(new User)->getTable()."
				    ON users.id = goals.provider_id
				WHERE provider_id IN (".$provider_ids.")
				  AND (users.is_active  = 1 OR users.is_active = '1')
				  AND goals.status_id = 1)";
	$result = DB::select($query);
    return $result[0]->user_count;
}


function calculateSumOfGoalTagsLatestActivity($tag_ids,$start_date,$end_date){
	$tag_ids = implode(',', $tag_ids);
	$query = "(SELECT
			 SUM(CAST(
			    CAST(
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at >= '".DBDateFormat($start_date)."'
			        AND created_at <= '".DBDateFormat($end_date)."'
			      ORDER BY id DESC
			      LIMIT 1) ,0))-
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at <= '".DBDateFormat($start_date)."'
			      ORDER BY id DESC
			      LIMIT 1) ,0)) AS CHAR
			    ) AS SIGNED
			  )) AS user_sum
			FROM
			  goals
				   LEFT JOIN ".with(new User)->getTable()."
				  	 ON goals.`provider_id` = users.`id`
				  LEFT JOIN ".with(new GoalTag)->getTable()."
				   ON goals.`id` = goal_tag.`goal_id`
					WHERE ".with(new Goal)->getTable().".goal_start_date >= '".DBDateFormat($start_date)
	."'AND ".with(new Goal)->getTable().".goal_closed_date <= '".DBDateFormat($end_date)
	."' AND goal_tag.tag_id IN (".$tag_ids."))";
	$result = DB::select($query);
    return $result[0]->user_sum;
}

function calculateSumOfGoalTagsCount($tag_ids,$start_date,$end_date){
	$tag_ids = implode(',', $tag_ids);
	$query =  "(SELECT
         count(*) as user_count
		       FROM
		   goals
		   LEFT JOIN
		    goal_activity
		       ON goals.id = goal_activity.goal_id
		         AND goal_activity.created_at >= '".DBDateFormat($start_date)."'
		         AND goal_activity.created_at <= '".DBDateFormat($end_date)."'
		   LEFT JOIN ".with(new User)->getTable()."
				    ON users.id = goals.provider_id
				  LEFT JOIN ".with(new GoalTag)->getTable()."
				   ON goals.`id` = goal_tag.`goal_id`
				WHERE goal_tag.tag_id IN (".$tag_ids.")
			AND ".with(new Goal)->getTable().".goal_start_date >= '".DBDateFormat($start_date)."'AND ".with(new Goal)->getTable().".goal_closed_date <= '".DBDateFormat($end_date)."' )";

	$result = DB::select($query);

    return $result[0]->user_count;
}

function calculateTagsAvgCount($tags,$start_date,$end_date){
	if(calculateSumOfGoalTagsCount($tags,$start_date,$end_date) == 0){
        return 0;
    }

    return (calculateSumOfGoalTagsLatestActivity($tags,$start_date,$end_date) / calculateSumOfGoalTagsCount($tags,$start_date,$end_date));
}

function calculateProgramParticipantReportGoals($program_id,$start_date,$end_date){

    return calculateGoalProgressProgramAverages($program_id,$start_date,$end_date);

//	if($program_id && calculateGoalProgressProgramCount($program_id,$start_date,$end_date) == 0){
//        return 0;
//    }
//
//    return (calculateGoalProgressProgramSumCount($program_id,$start_date,$end_date) / calculateGoalProgressProgramCount($program_id,$start_date,$end_date));
}

function calculateGoalProgressProgramSumCount($program_id,$start_date,$end_date){

	$query =   '(SELECT
			 SUM(CAST(
			    CAST(
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at >= "'.DBDateFormat($start_date).'"
			        AND created_at <= "'.DBDateFormat($end_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0))-
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at <= "'.DBDateFormat($start_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0)) AS CHAR
			    ) AS SIGNED
			  )) AS goal_count
			FROM
			  goals
			  LEFT JOIN program_provider AS pp
			    ON goals.`provider_id` = pp.`provider_id`
			  LEFT JOIN user_details
			    ON goals.provider_id = user_details.`user_id`
			    WHERE pp.program_id ='.$program_id.'
			     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
			.'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
			.'")';
	$result = DB::select($query);
    return $result[0]->goal_count;
}

function calculateGoalProgressProgramAverages($program_id, $start_date, $end_date){
    $query ='(SELECT
         goals.id, name, date_of_activity, activity_ranking
		       FROM
		   goals
		   LEFT JOIN
		    goal_activity
		       ON goals.id = goal_activity.goal_id
		         AND goal_activity.created_at >=  "'.DBDateFormat($start_date).'"
		         AND goal_activity.created_at <= "'.DBDateFormat($end_date).'"
		   LEFT JOIN program_provider AS pp
		     ON goals.`provider_id` = pp.`provider_id`
		   LEFT JOIN user_details
		     ON goals.provider_id = user_details.`user_id`
		    WHERE pp.program_id = '.$program_id.'
		     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
        .'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
        .'")';
    //pr($query); die;
    $result = DB::select($query);
    return $result;
}

function calculateGoalProgressProgramCount($program_id,$start_date,$end_date){
	$query ='(SELECT
         count(*) as goal_count
		       FROM
		   goals
		   LEFT JOIN
		    goal_activity
		       ON goals.id = goal_activity.goal_id
		         AND goal_activity.created_at >=  "'.DBDateFormat($start_date).'"
		         AND goal_activity.created_at <= "'.DBDateFormat($end_date).'"
		   LEFT JOIN program_provider AS pp
		     ON goals.`provider_id` = pp.`provider_id`
		   LEFT JOIN user_details
		     ON goals.provider_id = user_details.`user_id`
		    WHERE pp.program_id = '.$program_id.'
		     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
	.'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
	.'")';
			//pr($query); die;
	$result = DB::select($query);
    return $result[0]->goal_count;
}

function calculateGoalProgressProgramProviderTypeSumCount($program_id,$provider_type_id,$start_date,$end_date){

	$query = '(SELECT
			 SUM(CAST(
			    CAST(
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at >= "'.DBDateFormat($start_date).'"
			        AND created_at <= "'.DBDateFormat($end_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0))-
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			        AND created_at <= "'.DBDateFormat($start_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0)) AS CHAR
			    ) AS SIGNED
			  )) AS goal_count
			FROM
			  goals
			  LEFT JOIN program_provider AS pp
			    ON goals.`provider_id` = pp.`provider_id`
			  LEFT JOIN user_details
			    ON goals.provider_id = user_details.`user_id`
			    WHERE pp.program_id ='.$program_id.'
			     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
			.'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
			.'" AND user_details.provider_type_id ='.$provider_type_id.')';
	$result = DB::select($query);
    return $result[0]->goal_count;
}

function calculateGoalProgressProgramProviderTypeCount($program_id,$start_date,$end_date){
    $query = '(SELECT
         goals.id, goal_activity.date_of_activity, goal_activity.activity_ranking, goals.provider_id, provider_type_id, pp.program_id, pt.name
		       FROM
		   goals
		   left join
		    goal_activity
		       ON goals.id = goal_activity.goal_id
		         AND goal_activity.created_at >=  "'.DBDateFormat($start_date).'"
		         AND goal_activity.created_at <= "'.DBDateFormat($end_date).'"
		   LEFT JOIN program_provider AS pp
		     ON goals.`provider_id` = pp.`provider_id`
		   LEFT JOIN user_details
		     ON goals.provider_id = user_details.`user_id`
		   LEFT JOIN provider_types AS pt
			 ON user_details.`provider_type_id` = pt.`id`
		   WHERE pp.program_id = '.$program_id.'
		     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
        .'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date).'")';

	$result = DB::select($query);
    return $result;
}

function calculateGoalProgressProgramProviderTypeAvgCount($program_id,$start_date,$end_date){
    return calculateGoalProgressProgramProviderTypeCount($program_id,$start_date,$end_date);
//	if(calculateGoalProgressProgramProviderTypeCount($program_id,$provider_type_id,$start_date,$end_date) == 0){
//        return 0;
//    }
//    return (calculateGoalProgressProgramProviderTypeSumCount($program_id,$provider_type_id,$start_date,$end_date) / calculateGoalProgressProgramProviderTypeCount($program_id,$provider_type_id,$start_date,$end_date));
}

function calculateAverageGoalChangeByProgramSumCount($program_id,$start_date,$end_date){
	$query = '(SELECT
			 SUM(CAST(
			    CAST(
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			         AND created_at >= "'.DBDateFormat($start_date).'"
			         AND created_at <= "'.DBDateFormat($end_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0))-
			      (SELECT IFNULL((SELECT
			        activity_ranking
			      FROM
			        goal_activity
			      WHERE goals.id = goal_id
			         AND created_at <= "'.DBDateFormat($start_date).'"
			      ORDER BY id DESC
			      LIMIT 1) ,0)) AS CHAR
			    ) AS SIGNED
			  )) AS goal_count
			FROM
			  goals
			  LEFT JOIN program_provider AS pp
			    ON goals.`provider_id` = pp.`provider_id`
			  LEFT JOIN user_details
			    ON goals.provider_id = user_details.`user_id`
			    WHERE pp.program_id ='.$program_id.'
			     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
			.'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
			.'")';
	$result = DB::select($query);
    return $result[0]->goal_count;
}

function calculateAverageGoalChangeByProgramCount($program_id,$start_date,$end_date){

	$query = '(SELECT
         count(*) as goal_count
		       FROM
		   goals
		   LEFT JOIN
		    goal_activity
		       ON goals.id = goal_activity.goal_id
		         AND goal_activity.created_at >=  "'.DBDateFormat($start_date).'"
		         AND goal_activity.created_at <= "'.DBDateFormat($end_date).'"
		   LEFT JOIN program_provider AS pp
		     ON goals.`provider_id` = pp.`provider_id`
		   LEFT JOIN user_details
		     ON goals.provider_id = user_details.`user_id`
		    WHERE pp.program_id = '.$program_id.'
		     AND '.with(new Goal)->getTable().'.goal_start_date >= "'.DBDateFormat($start_date)
	.'"AND '.with(new Goal)->getTable().'.goal_closed_date <= "'.DBDateFormat($end_date)
	.'")';
	$result = DB::select($query);
    return $result[0]->goal_count;
}

function calculateAverageGoalChangeByProgram($program_id,$start_date,$end_date){
	return calculateAverageGoalChangeByProgramSumCount($program_id,$start_date,$end_date);
	if(calculateAverageGoalChangeByProgramCount($program_id,$start_date,$end_date) == 0){
        return 0;
    }
    return (calculateAverageGoalChangeByProgramSumCount($program_id,$start_date,$end_date) / calculateAverageGoalChangeByProgramCount($program_id,$start_date,$end_date));
}

function getProgramName($id){
	if(!empty($id)){
		$query = '(SELECT name FROM  '.with(new Program)->getTable().' WHERE id = '.$id.')';
		$result = DB::select($query);
    	return '(' .$result[0]->name . ')';
	}else{
		return '';
	}

}
