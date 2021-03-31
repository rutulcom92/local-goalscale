<?php

namespace App\Models;

use App\BaseModel;

class Events extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primarykey = 'event_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'event_type', 'event_name', 'created_at',
    ];


    public static function getEventsDt($request){
        $event = Self::withoutGlobalScopes()->select('*');

        return DataTables::of($event)
        ->addColumn('location',function($event){
            return $event->city;
        })
        ->addColumn('num_providers',function($event){
            if(!empty($event->num_providers)){
                return $event->num_providers;
            }
            return 0;

        })
        ->addColumn('num_users',function($event){
            if(!empty($event->num_providers)){
                return $event->num_users;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($event){
            if(!empty($event->num_providers)){
                return $event->avg_goal_change;
            }
            return 0;
        })
        ->editColumn('name',function($event){
            return '<a href="'.route('event.edit',$event->id).'">'.$event->name.'</a>';
        })
        ->addColumn('programs',function($event){
            $programs = array();
            if(!empty($event->programs)){
                foreach ($event->programs()->orderBy('name', 'ASC')->get() as $key => $value) {
                    $programs[] = '<a href="'.route('program.edit',$value->id).'">'.$value->name.'</a>';
                }
                 return implode(', ',$programs);
            }
           return 0;

        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (
                 SELECT event_id FROM ".with(new Program)->getTable()." as p WHERE p.event_id = ".with(new Self)->getTable().".id  AND name like ? LIMIT 1
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.event_id = '.with(new Self)->getTable().'.id
                ) $1')
        ->orderColumn('num_providers', 'num_providers $1')

        ->orderColumn('num_users', 'num_users $1')

        ->orderColumn('avg_goal_change', 'avg_goal_change $1')

        ->orderColumn('location', 'city $1')

        // ->setRowId(function ($event) {
        //     return route('event.edit',$event->id);
        // })
        ->rawColumns(['name', 'location','num_providers','num_users','programs','avg_goal_change'])->make(true);
    }

    public static function getEventDataByLogId($event_id) {

        $EventData = DB::table(with(new Events)->getTable())->where('event_id', $event_id)->first();
        if(!empty($EventData)){
            return $EventData;
        } else {
            return false;
        }
    }

}
