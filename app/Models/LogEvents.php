<?php

namespace App\Models;

use Auth;
use App\User;
use DataTables;
use App\BaseModel;
use App\Models\Events;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

class LogEvents extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_events';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primarykey = 'log_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_id', 'event_id', 'related_id', 'user_id', 'user_type_id', 'created_at',
    ];

    // Tags
    public function eventTypez()
    {
        return $this->belongsTo('App\Models\Events', 'event_id')->withTimestamps();
    }

    // eventType
    public function eventType(){
        return $this->belongsTo('App\Models\Events', 'event_id', 'event_id');
    }

    public static function getEventsDt($filters = []){

        $eventlogs = Self::select('*');

        if (!empty($filters['userTypesIdArray']) && count($filters['userTypesIdArray']) > 0) {
            $eventlogs->whereIn('user_type_id', $filters['userTypesIdArray']);
        }

        if (!empty($filters['eventIdsArray']) && count($filters['eventIdsArray']) > 0) {
            $eventlogs->whereIn('event_id', $filters['eventIdsArray']);
        }

        if (!empty($filters['eventNameIdsArray']) && count($filters['eventNameIdsArray']) > 0) {
            $eventlogs->whereIn('event_id', $filters['eventNameIdsArray']);
        }

        if (!empty($filters['event_from_date'])) {
            $eventlogs->where('created_at', '>=', DBDateFormat($filters['event_from_date']));
        }

        if (!empty($filters['event_to_date'])) {
            $eventlogs->where('created_at', '<=', DBDateFormat($filters['event_to_date']));
        }

        return DataTables::of($eventlogs)
        ->addColumn('event_name',function($eventlog){
            $event = Self::getEventDataByEventId($eventlog->event_id);
            return $event->event_name;
        })
        ->addColumn('event_type',function($eventlog){
            $event = Self::getEventDataByEventId($eventlog->event_id);
            return $event->event_type;
        })
        ->addColumn('description',function($eventlog){
            return !empty($eventlog->description)?$eventlog->description:'-';
        })
        ->addColumn('related_id',function($eventlog){
            $related_id =  $eventlog->related_id;
            $event = Self::getEventDataByEventId($eventlog->event_id);
            $event_type = $event->event_type;
            if ($related_id > 0) {
                if ($event_type == "goal") {
                    return "<a href='".route('goal.view',$related_id)."'>".$related_id."</a>";
                } else if ($event_type == "user") {
                    $user_type = DB::table(with(new UserType)->getTable())->where('id', $eventlog->user_type_id)->first();
                    //echo "<br>---".
                    $user_type_name = strtolower($user_type->name);
                    if($user_type_name == "organization admin") {
                        return "<a href='".route('admin.edit',$related_id)."'>".$related_id."</a>";
                    } else {
                        return "<a href='".route($user_type_name.'.edit',$related_id)."'>".$related_id."</a>";
                    }                    
                } else if ($event_type == "organization") {
                    return "<a href='".route('organization.edit',$related_id)."'>".$related_id."</a>";
                } else if ($event_type == "program") {
                    return "<a href='".route('program.edit',$related_id)."'>".$related_id."</a>";
                } else if ($event_type == "supervisor") {
                    return "<a href='".route('supervisor.edit',$related_id)."'>".$related_id."</a>";
                } else if ($event_type == "provider") {
                    return "<a href='".route('provider.edit',$related_id)."'>".$related_id."</a>";
                } else if ($event_type == "participant") {
                    return "<a href='".route('participant.edit',$related_id)."'>".$related_id."</a>";
                }
            } else {
                return '-';
            }
        })
        ->addColumn('email',function($eventlog){
            return !empty($eventlog->email)?$eventlog->email:'-';
        })
        ->addColumn('event_user_type',function($eventlog){
            if(!empty($eventlog->user_type_id)) {
                $user_type = DB::table(with(new UserType)->getTable())->where('id', $eventlog->user_type_id)->first();
            // $user_type = UserType::select('*')->whereId($eventlog->user_type_id);
                return $user_type->name;
            } else {
                return '-';
            }
        })
        ->addColumn('event_by',function($eventlog){
            if(!empty($eventlog->user_type_id)) {
                $user_type = DB::table(with(new User)->getTable())->where('id', $eventlog->user_id)->first();
                return $user_type->first_name. ' '. $user_type->last_name;
            } else {
                return '-';
            }
        })
        ->addColumn('created_at', function($eventlog) {
            return date("M d, Y h:i:s A", strtotime($eventlog->created_at));
        })
        ->filterColumn('event_name', function ($query, $keyword) {
            $query->whereRaw("event_id = (SELECT
                        event_id
                        FROM
                        ".with(new Events)->getTable()." AS gs
                        WHERE gs.event_id IN ( SELECT event_id FROM ".with(new Events)->getTable()." WHERE event_name like ? )
                        AND gs.event_id = ".with(new Self)->getTable().".event_id
                    )", ["%{$keyword}%"]);
         })
         ->filterColumn('event_type', function ($query, $keyword) {
            $query->whereRaw("event_id = (SELECT
                        event_id
                        FROM
                        ".with(new Events)->getTable()." AS gs
                        WHERE gs.event_id IN ( SELECT event_id FROM ".with(new Events)->getTable()." WHERE event_type like ? )
                        AND gs.event_id = ".with(new Self)->getTable().".event_id
                    )", ["%{$keyword}%"]);
         })
         ->filterColumn('event_user_type', function ($query, $keyword) {
            $query->whereRaw("user_type_id = (SELECT
                        id
                        FROM
                        ".with(new UserType)->getTable()." AS gs
                        WHERE gs.id IN ( SELECT id FROM ".with(new UserType)->getTable()." WHERE name like ? )
                        AND gs.id = ".with(new Self)->getTable().".user_type_id
                    )", ["%{$keyword}%"]);
         })
         ->filterColumn('event_by', function ($query, $keyword) {
            $query->whereRaw("user_id = (SELECT
                        id
                        FROM
                        ".with(new User)->getTable()." AS gs
                        WHERE gs.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                        AND gs.id = ".with(new Self)->getTable().".user_id
                    )", ["%{$keyword}%"]);
         })
         ->orderColumn('created_at', 'created_at $1')
        ->rawColumns(['event_name','description','email', 'event_type', 'related_id', 'event_by', 'created_at', 'action'])->make(true);
    }

    public static function getEventDataByEventId($event_id) {

        $EventData = DB::table(with(new Events)->getTable())->where('event_id', $event_id)->first();
        if(!empty($EventData)){
            return $EventData;
        } else {
            return false;
        }
    }

}
