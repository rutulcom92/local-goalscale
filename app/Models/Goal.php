<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Tag;
use App\Models\GoalScale;
use App\BaseModel;
use DataTables;
use App\Traits\GoalTrait;
use App\User;
use Auth;

class Goal extends BaseModel
{
    use GoalTrait;

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goals';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primarykey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'goal_start_date', 'status_id', 'participant_id', 'provider_id', 'goal_change', 'last_activity_date', 'goal_closed_date', 'is_active', 'created_by', 'last_modified_by',
    ];

    public function getDateCreatedAttribute() {
        return date('M d, Y', strtotime($this->created_at));
    }

    public function getDateUpdatedAttribute() {
        return date('M d, Y', strtotime($this->updated_at));
    }

    // Scales
    public function scales()
    {
        return $this->hasMany('App\Models\GoalScale', 'goal_id', 'id');
    }

    // Activities
    public function activities()
    {
        return $this->hasMany('App\Models\GoalActivity', 'goal_id', 'id');
    }

    // Latest Activity
    public function latestActivity()
    {
        return $this->activities()->latest()->limit(1);
    }

    // Tags
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'goal_tag', 'goal_id', 'tag_id')->withTimestamps();
    }

    // Provider
    public function provider(){
        return $this->belongsTo('App\User', 'provider_id', 'id');
    }

    // Participant
    public function participant(){
        return $this->belongsTo('App\User', 'participant_id', 'id');
    }

    // Goal Owner
    public function owner(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    // Goal Status
    public function status(){
        return $this->belongsTo('App\Models\GoalStatus', 'status_id', 'id');
    }

    public static function goalsDt($filters = []) {

        $goals = Self::select('*');

        if(Auth::user()->user_type_id == providerUserTypeId()){
            $goals =  $goals->where('provider_id', Auth::user()->id);
        }

        if(Auth::user()->user_type_id == participantUserTypeId()){
            $goals =  $goals->where('participant_id', Auth::user()->id);
        }

        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $goals =  $goals->whereHas('provider',function($query){
                $query->whereHas('providersSupervisor',function($query1){
                    $query1->whereSupervisorId(Auth::user()->id);
                });
            });
        }

        if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $goals->whereHas('provider', function (Builder $query) use($filters) {
                $query->where('organization_id',Auth::user()->organization_id);
            });
        }

        if (!empty($filters['providersIdArray']) && count($filters['providersIdArray']) > 0) {
            $goals->whereIn('provider_id', $filters['providersIdArray']);
        }

        if (!empty($filters['participantsIdArray']) && count($filters['participantsIdArray']) > 0) {
            $goals->whereIn('participant_id', $filters['participantsIdArray']);
        }

        if (!empty($filters['organization'])) {
            $goals->whereHas('provider', function (Builder $query) use($filters) {
                $query->where('organization_id', $filters['organization']);
            });
        }

        if (!empty($filters['tag'])) {
            $goals->whereHas('tags', function (Builder $query) use($filters) {
                $query->where(with(new Tag)->getTable().'.id', $filters['tag']);
            });
        }

        return DataTables::of($goals)
            ->addColumn('name', function($goal) {
               return "<a href='".route('goal.view',$goal->id)."'>$goal->name</a>";
            })
            ->addColumn('participant', function($goal) {
                return '<div class="for_user"><img src="'.$goal->participant->image.'"></div><label>'.$goal->participant->full_name.'</label>';
            })
            ->addColumn('provider', function($goal) {
                return '<div class="for_user"><img src="'.$goal->provider->image.'"></div><label>'.$goal->provider->full_name.'</label>';
            })
            ->addColumn('tags', function($goal){
                return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
            })
            ->addColumn('status', function($goal) {
                if (!empty($goal->status)) {
                    if ($goal->status->id == 3) {
                        return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                    } else {
                        return $goal->status->name;
                    }
                }
                return '-';
            })
            ->addColumn('action', function($goal){
                if(Auth::user()->user_type_id == superAdminUserTypeId() || Auth::user()->user_type_id == supervisorUserTypeId()){
                    return "<a href='".route('goal.edit',$goal->id)."'>Edit</a>";
                }
            })
            ->editColumn('created_at', function($goal) {
                return $goal->date_created;
            })
            ->editColumn('updated_at', function($goal) {
                return $goal->date_updated;
            })
            ->editColumn('goal_change', function($goal) {

                if (is_null($goal->goal_change)) {
                    return '';
                } else if ($goal->goal_change == 0) {
                    return $goal->goal_change;
                }
                return sprintf("%+d", $goal->goal_change);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereRaw("status_id = (SELECT
                        id
                        FROM
                        ".with(new GoalStatus)->getTable()." AS gs
                        WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                        AND gs.id = ".with(new Self)->getTable().".status_id
                    )", ["%{$keyword}%"]);
            })
            ->filterColumn('provider', function ($query, $keyword) {
                $query->whereRaw("provider_id = (SELECT
                        id
                        FROM
                        ".with(new User)->getTable()." AS u
                        WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                        AND u.id = ".with(new Self)->getTable().".provider_id
                    )", ["%{$keyword}%"]);
            })
            ->filterColumn('participant', function ($query, $keyword) {
                $query->whereRaw("participant_id = (SELECT
                        id
                        FROM
                        ".with(new User)->getTable()." AS u
                        WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                        AND u.id = ".with(new Self)->getTable().".participant_id
                    )", ["%{$keyword}%"]);
            })
            ->filterColumn('tags', function ($query, $keyword) {
                 $query->whereRaw("id = (SELECT
                        goal_id
                        FROM
                        ".with(new GoalTag)->getTable()." AS gt
                        WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                        AND  gt.goal_id = ".with(new Self)->getTable().".id
                    )", ["%{$keyword}%"]);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("name like ?", ["%{$keyword}%"]);
            })
            ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')
            ->orderColumn('name', 'name $1')
            ->orderColumn('created_at', 'created_at $1')
            ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

            ->orderColumn('tags', '(SELECT
                       GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                    FROM
                        '.with(new Tag)->getTable().' AS t
                    WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
                )) $1')

            ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')

            // ->setRowId(function ($goal) {
            //     return route('goal.edit',$goal->id);
            // })

            ->rawColumns(['name','participant', 'provider', 'tags', 'status', 'action'])->make(true);
    }

    public static function  getSupervisorGoalsDt($id,$request){
        $goals = Self::select('*')->whereHas('provider',function($query) use($id){
                $query->whereHas('providerSupervisor',function($query1) use($id){
                    $query1->whereSupervisorId($id);
                });
        });

        if(!empty($request->filter_by_provider)) {
            $goals =  $goals->whereProviderId($request->filter_by_provider);
        }

        if(!empty($request->filter_by_participant)) {
             $goals = $goals->whereParticipantId($request->filter_by_participant);
        }

        return DataTables::of($goals)
        ->addColumn('name',function($goal){
            return "<a href='".route('goal.edit',$goal->id)."'>$goal->name</a>";
        })
        ->addColumn('participant', function($goal) {
            return '<div class="for_user"><img src="'.$goal->participant->image.'"></div><label>'.$goal->participant->full_name.'</label>';
        })
        ->addColumn('provider', function($goal) {
            return '<div class="for_user"><img src="'.$goal->provider->image.'"></div><label>'.$goal->provider->full_name.'</label>';
        })
        ->addColumn('tags', function($goal){
            return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
        })
        ->addColumn('status', function($goal) {
            if (!empty($goal->status)) {
                if ($goal->status->id == 3) {
                    return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                } else {
                    return $goal->status->name;
                }
            }
            return '-';
        })
        ->addColumn('edit_goal', function($goal){
            return '<a href="'.route('goal.edit',$goal->id).'">Edit</a>';
        })
        ->editColumn('created_at', function($goal) {
            return $goal->date_created;
        })
        ->editColumn('updated_at', function($goal) {
            return $goal->date_updated;
        })
        ->editColumn('goal_change', function($goal) {

            if (is_null($goal->goal_change)) {
                return '';
            } else if ($goal->goal_change == 0) {
                return $goal->goal_change;
            }
            return sprintf("%+d", $goal->goal_change);
        })
        ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("status_id = (SELECT
                    id
                    FROM
                    ".with(new GoalStatus)->getTable()." AS gs
                    WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                    AND gs.id = ".with(new Self)->getTable().".status_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('provider', function ($query, $keyword) {
            $query->whereRaw("provider_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".provider_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('participant', function ($query, $keyword) {
            $query->whereRaw("participant_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".participant_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('tags', function ($query, $keyword) {
             $query->whereRaw("id = (SELECT
                    goal_id
                    FROM
                    ".with(new GoalTag)->getTable()." AS gt
                    WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                    AND  gt.goal_id = ".with(new Self)->getTable().".id
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')
        ->orderColumn('name', 'name $1')
        ->orderColumn('created_at', 'created_at $1')
        ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

        ->orderColumn('tags', '(SELECT
                   GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                FROM
                    '.with(new Tag)->getTable().' AS t
                WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
            )) $1')

        ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')

        ->rawColumns(['name', 'participant', 'provider', 'created_at', 'updated_at', 'tags', 'goal_change', 'status'])->make(true);
    }

    public static function getProviderGoalDt($id, $request){
        $goals = Self::select('*')->whereProviderId($id);

        return DataTables::of($goals)
        ->addColumn('name',function($goal){
            return "<a href='".route('goal.edit',$goal->id)."'>$goal->name</a>";
        })
        ->addColumn('participant', function($goal) {
            return '<div class="for_user"><img src="'.$goal->participant->image.'"></div><label><a href="'.route("participant.edit",$goal->participant_id).'">'.$goal->participant->full_name.'</a></label>';
        })
        ->addColumn('tags', function($goal){
            return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
        })
        ->addColumn('status', function($goal) {
            if (!empty($goal->status)) {
                if ($goal->status->id == 3) {
                    return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                } else {
                    return $goal->status->name;
                }
            }
            return '-';
        })
        ->editColumn('created_at', function($goal) {
            return $goal->date_created;
        })
        ->editColumn('updated_at', function($goal) {
            return $goal->date_updated;
        })
        ->editColumn('goal_change', function($goal) {

            if (is_null($goal->goal_change)) {
                return '';
            } else if ($goal->goal_change == 0) {
                return $goal->goal_change;
            }
            return sprintf("%+d", $goal->goal_change);
        })
        ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("status_id = (SELECT
                    id
                    FROM
                    ".with(new GoalStatus)->getTable()." AS gs
                    WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                    AND gs.id = ".with(new Self)->getTable().".status_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('participant', function ($query, $keyword) {
            $query->whereRaw("participant_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                    AND u.id = ".with(new Self)->getTable().".participant_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('provider', function ($query, $keyword) {
            $query->whereRaw("provider_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                    AND u.id = ".with(new Self)->getTable().".provider_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('tags', function ($query, $keyword) {
             $query->whereRaw("id = (SELECT
                    goal_id
                    FROM
                    ".with(new GoalTag)->getTable()." AS gt
                    WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                    AND  gt.goal_id = ".with(new Self)->getTable().".id
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')
        ->orderColumn('name', 'name $1')
        ->orderColumn('created_at', 'created_at $1')
        ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

        ->orderColumn('tags', '(SELECT
                   GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                FROM
                    '.with(new Tag)->getTable().' AS t
                WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
            )) $1')

        ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')

        ->rawColumns(['name', 'participant', 'created_at', 'updated_at', 'tags', 'goal_change', 'status'])->make(true);

    }

    public static function getParticipantGoalDt($id, $request){
        $goals = Self::select('*')->whereParticipantId($id);

        return DataTables::of($goals)
         ->editColumn('name',function($goal){
            return "<a href='".route('goal.edit',$goal->id)."'>$goal->name</a>";
        })
        ->addColumn('tags', function($goal){
            return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
        })
        ->addColumn('status', function($goal) {
            if (!empty($goal->status)) {
                if ($goal->status->id == 3) {
                    return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                } else {
                    return $goal->status->name;
                }
            }
            return '-';
        })
        ->editColumn('created_at', function($goal) {
            return $goal->date_created;
        })
        ->editColumn('updated_at', function($goal) {
            return $goal->date_updated;
        })
        ->editColumn('goal_change', function($goal) {

            if (is_null($goal->goal_change)) {
                return '';
            } else if ($goal->goal_change == 0) {
                return $goal->goal_change;
            }
            return sprintf("%+d", $goal->goal_change);
        })
        ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("status_id = (SELECT
                    id
                    FROM
                    ".with(new GoalStatus)->getTable()." AS gs
                    WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                    AND gs.id = ".with(new Self)->getTable().".status_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('tags', function ($query, $keyword) {
             $query->whereRaw("id = (SELECT
                    goal_id
                    FROM
                    ".with(new GoalTag)->getTable()." AS gt
                    WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                    AND  gt.goal_id = ".with(new Self)->getTable().".id
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')
        ->orderColumn('name', 'name $1')
        ->orderColumn('created_at', 'created_at $1')
        ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

        ->orderColumn('tags', '(SELECT
                   GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                FROM
                    '.with(new Tag)->getTable().' AS t
                WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
            )) $1')

        ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')
        ->rawColumns(['name', 'created_at', 'updated_at', 'tags', 'goal_change', 'status'])->make(true);

    }

     public static function  getOrganizationGoalDt($id,$request){
        $goals = Self::select('*')->whereHas('participant',function($query) use($id){
                $query->whereHas('organization',function($query1) use($id){
                    $query1->whereId($id);
                });
        });

        if(!empty($request->filter_by_provider)) {
            $goals = $goals->whereProviderId($request->filter_by_provider);
        }

        if(!empty($request->filter_by_participant)) {
             $goals = $goals->whereParticipantId($request->filter_by_participant);
        }

        return DataTables::of($goals)
        ->editColumn('name',function($goal){
            return "<a href='".route('goal.edit',$goal->id)."'>$goal->name</a>";
        })
        ->addColumn('participant', function($goal) {
            return '<div class="for_user"><img src="'.$goal->participant->image.'"></div><label>'.$goal->participant->full_name.'</label>';
        })
        ->addColumn('provider', function($goal) {
            return '<div class="for_user"><img src="'.$goal->provider->image.'"></div><label>'.$goal->provider->full_name.'</label>';
        })
        ->addColumn('tags', function($goal){
            return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
        })
        ->addColumn('status', function($goal) {
            if (!empty($goal->status)) {
                if ($goal->status->id == 3) {
                    return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                } else {
                    return $goal->status->name;
                }
            }
            return '-';
        })
        ->editColumn('created_at', function($goal) {
            return $goal->date_created;
        })
        ->editColumn('updated_at', function($goal) {
            return $goal->date_updated;
        })
        ->editColumn('goal_change', function($goal) {

            if (is_null($goal->goal_change)) {
                return '';
            } else if ($goal->goal_change == 0) {
                return $goal->goal_change;
            }
            return sprintf("%+d", $goal->goal_change);
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("status_id = (SELECT
                    id
                    FROM
                    ".with(new GoalStatus)->getTable()." AS gs
                    WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                    AND gs.id = ".with(new Self)->getTable().".status_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('provider', function ($query, $keyword) {
            $query->whereRaw("provider_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".provider_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('participant', function ($query, $keyword) {
            $query->whereRaw("participant_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".participant_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('tags', function ($query, $keyword) {
             $query->whereRaw("id IN (SELECT
                    goal_id
                    FROM
                    ".with(new GoalTag)->getTable()." AS gt
                    WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')

        ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

        ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')

        ->orderColumn('created_at', 'created_at $1')

        ->orderColumn('name', 'name $1')

        ->orderColumn('tags', '(SELECT
                   GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                FROM
                    '.with(new Tag)->getTable().' AS t
                WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
            )) $1')

        ->rawColumns(['name', 'participant', 'provider', 'created_at', 'updated_at', 'tags', 'goal_change', 'status'])->make(true);
    }

       public static function  getProgramGoalDt($id,$request){

        $goals = Self::select('*')->whereHas('provider',function($query) use($id){
                $query->whereHas('programProvider',function($query1) use($id){
                    $query1->whereProgramId($id);
                });
        });

        if(!empty($request->filter_by_provider)) {
            $goals = $goals->whereProviderId($request->filter_by_provider);
        }

        if(!empty($request->filter_by_participant)) {
             $goals = $goals->whereParticipantId($request->filter_by_participant);
        }

        return DataTables::of($goals)
        ->editColumn('name',function($goal){
            return "<a href='".route('goal.edit',$goal->id)."'>$goal->name</a>";
        })
        ->addColumn('participant', function($goal) {
            return '<div class="for_user"><img src="'.$goal->participant->image.'"></div><label>'.$goal->participant->full_name.'</label>';
        })
        ->addColumn('provider', function($goal) {
            return '<div class="for_user"><img src="'.$goal->provider->image.'"></div><label>'.$goal->provider->full_name.'</label>';
        })
        ->addColumn('tags', function($goal){
            return view('goal.datatables.tags-column')->with(['goal' => $goal])->render();
        })
        ->addColumn('status', function($goal) {
            if (!empty($goal->status)) {
                if ($goal->status->id == 3) {
                    return '<span class="goal-status-pending-approval">'.$goal->status->name.'</span>';
                } else {
                    return $goal->status->name;
                }
            }
            return '-';
        })
        ->editColumn('created_at', function($goal) {
            return $goal->date_created;
        })
        ->editColumn('updated_at', function($goal) {
            return $goal->date_updated;
        })
        ->editColumn('goal_change', function($goal) {

            if (is_null($goal->goal_change)) {
                return '';
            } else if ($goal->goal_change == 0) {
                return $goal->goal_change;
            }
            return sprintf("%+d", $goal->goal_change);
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("status_id = (SELECT
                    id
                    FROM
                    ".with(new GoalStatus)->getTable()." AS gs
                    WHERE gs.id IN ( SELECT id FROM ".with(new GoalStatus)->getTable()." WHERE name like ? )
                    AND gs.id = ".with(new Self)->getTable().".status_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('provider', function ($query, $keyword) {
            $query->whereRaw("provider_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".provider_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('participant', function ($query, $keyword) {
            $query->whereRaw("participant_id = (SELECT
                    id
                    FROM
                    ".with(new User)->getTable()." AS u
                    WHERE u.id IN ( SELECT id FROM ".with(new User)->getTable()." WHERE first_name like ? )
                    AND u.id = ".with(new Self)->getTable().".participant_id
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('tags', function ($query, $keyword) {
             $query->whereRaw("id IN (SELECT
                    goal_id
                    FROM
                    ".with(new GoalTag)->getTable()." AS gt
                    WHERE gt.tag_id IN ( SELECT id FROM ".with(new Tag)->getTable()." WHERE tag like ? )
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('status', '(SELECT name FROM '.with(new GoalStatus)->getTable().' AS gs WHERE gs.id = '.with(new Self)->getTable().'.status_id) $1')

        ->orderColumn('provider', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.provider_id) $1')

        ->orderColumn('participant', '(SELECT GROUP_CONCAT(first_name,last_name) FROM '.with(new User)->getTable().' AS u WHERE u.id = '.with(new Self)->getTable().'.participant_id) $1')

        ->orderColumn('created_at', 'created_at $1')

        ->orderColumn('name', 'name $1')

        ->orderColumn('tags', '(SELECT
                   GROUP_CONCAT(t.tag ORDER BY t.tag ASC)
                FROM
                    '.with(new Tag)->getTable().' AS t
                WHERE t.id IN (SELECT tag_id FROM '.with(new GoalTag)->getTable().'  WHERE goal_id = '.with(new Self)->getTable().'.id
            )) $1')

        ->rawColumns(['name', 'participant', 'provider', 'created_at', 'updated_at', 'tags', 'goal_change', 'status'])->make(true);
    }

    public static function insertGoalData($data) {
        $value = DB::table(with(new Self)->getTable())->where('name', $data['name'])->get();
        if($value->count() == 0){
            DB::table(with(new Self)->getTable())->insert($data);
            return DB::getPdo()->lastInsertId();
        }
    }

    public static function getTagDataByTagName($TageName) {

        $TagData = DB::table(with(new Tag)->getTable())->where('tag', $TageName)->first();
        if(!empty($TagData)){
            return $TagData;
        } else {
            return false;
        }
    }

    public static function getUserDataByEmail($email) {

        $UserData = DB::table(with(new User)->getTable())->where('email', $email)->first();
        if(!empty($UserData)){
            return $UserData;
        } else {
            return false;
        }
    }

    public static function getScaleDataByScaleValue($id,$key){
        $ScaleData = DB::table(with(new GoalScale)->getTable())->where('goal_id', $id)->where('value', strval($key))->first();
        if(!empty($ScaleData)){
            return $ScaleData;
        } else {
            return false;
        }
    }

    public static function updateScaleValue($id,$key,$description){
        $ScaleData = DB::table(with(new GoalScale)->getTable())->where('goal_id', $id)->where('value', strval($key))->update(['description' => $description,'last_modified_by' => Auth::user()->id,'updated_at' => date('Y-m-d H:i:s')]);
        if(!empty($ScaleData)){
            return $ScaleData;
        } else {
            return false;
        }
    }
}
