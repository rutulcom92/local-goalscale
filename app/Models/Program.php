<?php

namespace App\Models;

use DataTables;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\UserDetail;
use App\Models\ProgramSupervisor;
use App\Models\ProgramProvider;
use App\BaseModel;
use Auth;
use App\Scopes\StatusScope;
use DB;

class Program extends BaseModel
{

    protected $table = 'programs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name','image','organization_id','contact_email','contact_phone','address','city','state_id','zip','country_id','record_num','notes','date_added','is_active','created_by','last_modified_by'
    ];


    public function getImageAttribute() {
        
        return !empty($this->attributes['image']) && file_exists(Storage::path(config('constants.program_image_storage_path').$this->attributes['image'])) ? url(Storage::url(config('constants.program_image_storage_path').$this->attributes['image'])) : '';
    }
    
    // organization
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization', 'organization_id','id');
    }

    public function ProgramSupervisors(){
         return $this->belongsToMany('App\User', 'program_supervisor', 'program_id', 'supervisor_id')->withTimestamps();
    }

    public function ProgramProviders(){
         return $this->belongsToMany('App\User', 'program_provider', 'program_id', 'provider_id')->withTimestamps();
    }

    public function ProgramParticipants(){
         return $this->belongsToMany('App\User', 'program_participant', 'program_id', 'participant_id')->withTimestamps();
    }

     public function ProgramOrgAdmins(){
         return $this->belongsToMany('App\User', 'program_org_admin', 'program_id', 'admin_id')->withTimestamps();
    }

    public static function getProgramsDt($request)
    {
        $program = Self::withoutGlobalScopes()->with(['organization'])->select('*');  

        if(Auth::user()->user_type_id == supervisorUserTypeId()){
            $program = $program->whereHas('ProgramSupervisors',function($query){
                $query->whereSupervisorId(Auth::user()->id);
            });
        }

        if(Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $program = $program->whereHas('ProgramOrgAdmins',function($query){
                $query->whereAdminId(Auth::user()->id);
            });
        }

        return DataTables::of($program)
        ->addColumn('supervisors',function($program){
        
        $users = array();
            if(!empty($program->ProgramSupervisors)){
                foreach ($program->ProgramSupervisors as $key => $value) {
                    $users[] =  $value->first_name ." ". $value->last_name;
                }
            }
             return implode('<br> ',$users);
        })
        ->addColumn('name',function($program){
            return "<a href='".route('program.edit',$program->id)."'>$program->name</a>";
        })
        ->addColumn('num_providers',function($program){
            $num_providers =  $program->ProgramProviders()->get()->count();
            if($num_providers > 0){
                 return $program->ProgramProviders()->get()->count();
            }
            return 0;
        })
        ->addColumn('num_users',function($program){
            $result = DB::select(calculateProgramParticipants($program->id));
            return $result[0]->participant_count;
            $result = $program->withCount(['ProgramParticipants' => function($query){
                $query->with(['user' => function($query2){
                    $query2->whereIsActive('1');
                }]);
             }])->where('id',$program->id)->first();
            if(!empty($result)){
                return $result->program_participants_count;
            }
            else{
                return 0; 
            }
        })
        ->addColumn('num_user_goals',function($program){
             // pr($program->withCount(['ProgramParticipants' => function($query){
             //    $query->with(['user' => function($query2){
             //        $query2->whereIsActive('1');
             //    }]);
             // }])->where('id',$program->id)->get());exit();
            $result = DB::select(calculateProgramParticipantGoals($program->id));
            return $result[0]->goal_count;
        })
        ->addColumn('avg_goal_change',function($program){
            if(!empty($program->organization->avg_goal_change)){
                return $program->organization->avg_goal_change;
            }
            return 0;
        })
        ->editColumn('updated_at',function($program){
            if(!empty($program->updated_at)){
                return lastUpdateDisplay($program->updated_at);
            }
            return;
        })
        ->filterColumn('supervisors', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    program_id
                    FROM
                    ".with(new ProgramSupervisor)->getTable()." AS ps
                    WHERE ps.supervisor_id = ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? LIMIT 1)
                    AND  ps.program_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->orderColumn('supervisors', '(SELECT
                       GROUP_CONCAT(u.first_name ORDER BY u.first_name ASC)
                    FROM
                        '.with(new User)->getTable().' AS u
                    WHERE u.id IN (SELECT supervisor_id FROM '.with(new ProgramSupervisor)->getTable().'  WHERE program_id = '.with(new Self)->getTable().'.id 
                )) $1')
        ->orderColumn('num_providers', '(SELECT count(provider_id) FROM '.with(new ProgramProvider)->getTable().' AS pp WHERE pp.program_id = '.with(new Self)->getTable().'.id) $1')
        
        ->orderColumn('num_users', '(SELECT count(*) as participant_count FROM '.with(new ProgramParticipant)->getTable().' AS pp  LEFT JOIN '.with(new User)->getTable().' As u ON u.id = pp.participant_id WHERE  u.is_active = "1" AND pp.program_id =  '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_user_goals', '(SELECT sum(ud.num_users_goals) as goal_count
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
                    u.is_active = "1" AND pp.program_id = '.with(new Program)->getTable().'.id) $1')
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

        ->orderColumn('name', 'name $1')
        // ->setRowId(function ($program) {
        //     return route('program.edit',$program->id);
        // })
        ->rawColumns(['name','supervisors','num_providers','num_users','num_user_goals','updated_at','avg_goal_change'])->make(true);
    }

    public static function getProgramSupervisorDt($id,$request)
    {
        $user = User::withoutGlobalScope(StatusScope::class)->select('*');

        if(Auth::user()->user_type_id == 2){
            $user = $user->whereId(Auth::user()->id);
        }
        else{
            $user = $user->whereHas('programSupervisor',function($query) use ($id){
                $query->where('program_id',$id);
            });    
        }        

        return DataTables::of($user)

        ->editColumn('image',function($user){
            $image = '<div class="for_user"><img src="';
            if(!empty($user->image)) 
            {
                $image .= $user->image.'" alt ="'.$user->image;
            } 
            else 
            {              
                $image .= asset("images/noImg.jpg");
            }
            $image .= '"></div>';
            return $image;

        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->editColumn('first_name',function($user){
            return $user->first_name;
        })
        ->editColumn('last_name',function($user){
            return $user->last_name;
        })
        ->addColumn('num_providers',function($user){
           if(!empty($user->userDetail->num_providers)){
                return $user->userDetail->num_providers;
            }
            return 0;
        })
        ->addColumn('num_users',function($user){
           if(!empty($user->userDetail->num_users)){
                return $user->userDetail->num_users;
            }
            return 0;
        })
        ->addColumn('num_users_goals',function($user){
            if(!empty($user->userDetail->num_users_goals)){
                return $user->userDetail->num_users_goals;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($user){
            if(!empty($user->userDetail->avg_goal_change)){
                return $user->userDetail->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('status',function($user){
          return getUserStatus($user->is_active);
        })
        
        ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new User)->getTable().'.id) $1')
        
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new User)->getTable().'.id) $1')
        
        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new User)->getTable().'.id) $1')
        
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new User)->getTable().'.id) $1')

        ->rawColumns(['image','first_name','last_name','num_providers','num_users','num_user_goals','updated_at','avg_goal_change'])->make(true);
    }

    public static function getProgramProviderDt($id,$request)
    {
        $user = User::with('userDetail')->where('user_type_id',3)->select('*');

        if(Auth::user()->user_type_id == 2){
            $user = $user->whereHas('providersSupervisor',function($query) use ($id){
                $query->where('supervisor_id',Auth::user()->id);
            });
        }
        $user = $user->whereHas('ProgramProvider',function($query) use ($id){
            $query->where('program_id',$id);
        });

        return DataTables::of($user)->editColumn('image',function($user){
            $image = '<div class="for_user"><img src="';
            if(!empty($user->image)) 
            {
                $image .= $user->image.'" alt ="'.$user->image;
            } 
            else 
            {              
                $image .= asset("images/noImg.jpg");
            }
            $image .= '"></div>';
            return $image;

        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
         ->addColumn('first_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->first_name</a>";
        })
        ->addColumn('last_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->last_name</a>";
        })
        ->addColumn('num_users',function($user){
            if(!empty($user->userDetail->num_users)){
                return $user->userDetail->num_users;
            }
            return 0;
        })
        ->addColumn('num_users_goals',function($user){
            if(!empty($user->userDetail->num_users_goals)){
                return $user->userDetail->num_users_goals;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($user){
            if(!empty($user->userDetail->avg_goal_change)){
                return $user->userDetail->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('status',function($user){
          return getUserStatus($user->is_active);
        })
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new User)->getTable().'.organization_id) $1')
        ->rawColumns(['image','first_name','last_name','num_users','num_user_goals','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function getOrganizationProgramsDt($id, $request){

       $program = Self::select('*')->whereOrganizationId($id);  

        return DataTables::of($program)
        ->addColumn('name',function($program){
            return "<a href='".route('program.edit',$program->id)."'>$program->name</a>";
        })
       ->addColumn('supervisors',function($program){
             $users = array();
            if(!empty($program->ProgramSupervisors)){
                foreach ($program->ProgramSupervisors as $key => $value) {
                    $users[] =  "<a href='".route('supervisor.edit',$value->id)."'>$value->first_name ". " "." $value->last_name</a>";
                }
            }
             return implode('<br> ',$users);
        })
        ->addColumn('num_providers',function($program){
             return $program->ProgramProviders()->get()->count();
        })
        ->addColumn('num_users',function($program){
            $result = DB::select(calculateProgramParticipants($program->id));
            return $result[0]->participant_count;
           // return $program->ProgramParticipants()->get()->count();
        })
        ->addColumn('num_user_goals',function($program){
           $result = DB::select(calculateProgramParticipantGoals($program->id));
           return $result[0]->goal_count;
        })
        ->addColumn('avg_goal_change',function($program){
            if(!empty($program->organization->avg_goal_change)){
                return $program->organization->avg_goal_change;
            }
        })
        ->editColumn('updated_at',function($program){
            if(!empty($program->updated_at)){
                return lastUpdateDisplay($program->updated_at);
            }
            return;
        })
        ->filterColumn('supervisors', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    program_id
                    FROM
                    ".with(new ProgramSupervisor)->getTable()." AS ps
                    WHERE ps.supervisor_id = ( SELECT id FROM ".with(new User)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? LIMIT 1)
                    AND  ps.program_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
         ->orderColumn('supervisors', '(SELECT
                       GROUP_CONCAT(u.first_name ORDER BY u.first_name ASC)
                    FROM
                        '.with(new User)->getTable().' AS u
                    WHERE u.id IN (SELECT supervisor_id FROM '.with(new ProgramSupervisor)->getTable().'  WHERE program_id = '.with(new Self)->getTable().'.id 
                )) $1')
        ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

        ->orderColumn('num_user_goals', '(SELECT num_goals FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        ->orderColumn('name', 'name $1')
        ->setRowId(function ($program) {
            return route('program.edit',$program->id);
        })
        ->rawColumns(['name','supervisors','num_providers','num_users','num_user_goals','updated_at','avg_goal_change'])->make(true);
    }

    public static function getSupervisorProgramsDt($id, $request){

        $program = Self::select('*')->whereHas('ProgramSupervisors',function($query) use ($id){
            $query->where('supervisor_id',$id)->with('userDetail');
        });

        return DataTables::of($program)
        ->addColumn('name',function($program){
            return "<a href='".route('program.edit',$program->id)."'>$program->name</a>";
        })
        ->addColumn('num_providers',function($program){
            if(!empty($program->organization->num_providers)){
                return $program->organization->num_providers;
            }
            return 0;
        })
        ->addColumn('num_users',function($program){
            if(!empty($program->organization->num_users)){
                return $program->organization->num_users;
            }
            return 0;
        })
         ->addColumn('num_user_goals',function($program){
             if(!empty($program->organization->num_goals)){
                return $program->organization->num_goals;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($program){
             if(!empty($program->organization->avg_goal_change)){
                return $program->organization->avg_goal_change;
            }
            return 0;
        })
        ->editColumn('updated_at',function($program){
            if(!empty($program->updated_at)){
                return lastUpdateDisplay($program->updated_at);
            }
            return;
        })
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("name like ?", ["%{$keyword}%"]);
        })
        ->orderColumn('name', 'name $1')

       ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

       ->orderColumn('num_users', '(SELECT num_users FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

       ->orderColumn('num_user_goals', '(SELECT num_goals FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

       ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
       
        ->setRowId(function ($program) {
            return route('program.edit',$program->id);
        })
        ->rawColumns(['name','num_providers','num_users','num_user_goals','updated_at','avg_goal_change'])->make(true);
    }

    public static function getProgramUsersDt($id, $request){

         $user = User::with('userDetail')->where('user_type_id',participantUserTypeId())->select('*');

        if(Auth::user()->user_type_id == 2){
            $user = $user->whereHas('participantProvider',function($query) use ($id){
                $query->whereHas('provider',function($query1) use ($id){
                 $query1->whereHas('providerSupervisor',function($query2) use ($id){
                     $query2->where('supervisor_id',Auth::user()->id);
                    });
                });
            });
        }

        $user = $user->whereHas('ProgramParticipant',function($query) use ($id){
            $query->where('program_id',$id);
        })->with('userDetail');

        if(!empty($request->filter_by_provider)) {
            $user = $user->whereHas('participantProvider',function($query) use ($request){
                $query->where('provider_id',$request->filter_by_provider);
            });
        }

        return DataTables::of($user)->editColumn('image',function($user){
            $image = '<div class="for_user"><img src="';
            if(!empty($user->image)) 
            {
                $image .= $user->image.'" alt ="'.$user->image;
            } 
            else 
            {              
                $image .= asset("images/noImg.jpg");
            }
            $image .= '"></div>';
            return $image;

        })
        ->addColumn('first_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->first_name</a>";
        })
        ->addColumn('last_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->editColumn('providers',function($user){
            $user = $user->userDetail->provider;
            $image = '<div class="for_user"><img src="';
            if(!empty($user->image)) 
            {
                $image .= $user->image.'" alt ="'.$user->image;
            }
            else
            {
                $image .= asset("images/noImg.jpg");
            }
            $image .= '"></div>';
            if(!empty($user->first_name) && !empty($user->last_name)){
                 $image .= '<label>'. $user->first_name .' '. $user->last_name.'</label>';
            }
            return $image;
        })
        ->addColumn('num_users_goals',function($user){
            if(!empty($user->userDetail->num_users_goals)){
                return $user->userDetail->num_users_goals;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($user){
            if(!empty($user->userDetail->avg_goal_change)){
                return $user->userDetail->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('status',function($user){
          return getUserStatus($user->is_active);
        })
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new User)->getTable().'.organization_id) $1')
        ->rawColumns(['image','first_name','last_name','num_users_goals','updated_at','providers','avg_goal_change','status'])->make(true);
    }
}