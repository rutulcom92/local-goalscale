<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DataTables;
use App\Models\UserDetail;
use App\Models\ProgramSupervisor;
use App\Models\ProgramProvider;
use App\Models\ProgramParticipant;
use App\Models\Program;
use App\Models\Organization;
use App\Models\ProviderSupervisor;
use App\Models\ProviderType;
use App\Models\ParticipantProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrait;
use Auth;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','user_type_id', 'email', 'password','phone','address','city','state_id','zip','ethnicity','record_num','organization_id','created_by','last_modified_by','last_login','image','notes','is_active','logo_image','inactive_date'
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getImageAttribute() {
        
        return !empty($this->attributes['image']) && file_exists(Storage::path(config('constants.user_profile_storage_path').$this->attributes['image'])) ? url(Storage::url(config('constants.user_profile_storage_path').$this->attributes['image'])) : asset('images/noImg.jpg'); 
    }

    public function getLogoImageAttribute() {    
        return !empty($this->attributes['logo_image']) && file_exists(Storage::path(config('constants.user_logo_storage_path').$this->attributes['logo_image'])) ? url(Storage::url(config('constants.user_logo_storage_path').$this->attributes['logo_image'])) : ''; 
    }

    public function getFullNameAttribute() {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    
    /**
     * checks if the user belongs to a particular group
     * @param string|array $role
     * @return bool
     */
    public function role($role) {
        return in_array($this->user_type_id, $role);
    }

    public function userDetail(){
        return $this->hasOne('App\Models\UserDetail','user_id','id');
    }

    public function userType(){
        return $this->hasOne('App\Models\UserType','id','user_type_id');
    }

    public function organization(){
        return $this->hasOne('App\Models\Organization','id','organization_id');
    }

    public function providerSupervisor(){
        return $this->hasOne('App\Models\ProviderSupervisor','provider_id','id');
    }

    public function state(){
        return $this->hasOne('App\Models\State','id','state_id');
    }

    public function programProvider(){
        return $this->belongsToMany('App\Models\Program', 'program_provider', 'provider_id', 'program_id')->withTimestamps();
    }

    public function programSupervisor(){
        return $this->belongsToMany('App\Models\Program', 'program_supervisor', 'supervisor_id', 'program_id')->withTimestamps();
    }

    public function programParticipant(){
        return $this->belongsToMany('App\Models\Program', 'program_participant', 'participant_id', 'program_id')->withTimestamps();
    }

    public function participantProvider(){
        return $this->hasMany('App\Models\ParticipantProvider', 'participant_id', 'id');
    }

    public function providerParticipant(){
        return $this->hasMany('App\Models\ParticipantProvider', 'provider_id', 'id');
    }

    public function programOrgAdmin(){
        return $this->belongsToMany('App\Models\Program', 'program_org_admin', 'admin_id', 'program_id')->withTimestamps();
    }
    //  public function providerSupervisor(){
    //     return $this->belongsToMany('App\Models\User', 'provider_supervisor', 'provider_id', 'supervisor_id')->withTimestamps();
    // }

    public function supervisorProviders() {
        return $this->belongsToMany('App\User', 'provider_supervisors', 'supervisor_id', 'provider_id')->withTimestamps();
    }

    public function providersSupervisor() {
        return $this->belongsToMany('App\User', 'provider_supervisors', 'provider_id', 'supervisor_id')->withTimestamps();
    }

    /**
     * Scope a query to sort users by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByName($query, $sort = 'ASC')
    {
        return $query->orderBy(\DB::raw('CONCAT(first_name, " ", last_name)'), $sort);
    }

    public static function getOrganizationSupervisorDt($id,$request){
        $user = Self::whereUserTypeId('2')->whereOrganizationId($id)->with(['userDetail','organization']);

        return DataTables::of($user)->editColumn('image',function($user){
            if(!empty($user->image)) 
            {
                $image ='<div class="for_user">
                            <img src="'.$user->image.'" alt ="'.$user->image.'">
                        </div>';
            } 
            else 
            {              
                $image ='<div class="for_user">
                            <img src="'.asset("images/noImg.jpg").'">
                        </div>';
            }
            return $image;

        })->editColumn('updated_at',function($user){
            if(!empty($user->updated_at)){
                return lastUpdateDisplay($user->updated_at);
            }
            return;
        })
        ->editColumn('first_name',function($user){
            return "<a href='".route('supervisor.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('supervisor.edit',$user->id)."'>$user->last_name</a>";
        })
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programSupervisor)){
                foreach ($user->programSupervisor()->get() as $key => $value) {
                    $programs[] = "<a href='".route('program.edit',$value->id)."'>$value->name</a>";
                }
            }
            return implode(', ',$programs);
        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    supervisor_id
                    FROM
                    ".with(new ProgramSupervisor)->getTable()." AS ps
                    WHERE ps.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND   ps.supervisor_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id IN (SELECT program_id FROM '.with(new ProgramSupervisor)->getTable().'  WHERE supervisor_id = '.with(new Self)->getTable().'.id 
                )) $1')
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
        ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.id = '.with(new Self)->getTable().'.id) $1')
        
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        ->setRowId(function ($user) {
            return route('supervisor.edit',$user->id);
        })->rawColumns(['image','first_name', 'last_name','num_providers','num_users','num_users_goals','programs','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function getSupervisorDt($request) {
        
        $user = Self::whereUserTypeId('2')->with(['userDetail','organization']);

        if(Auth::user()->user_type_id == 5){
            $user = $user->whereHas('userDetail',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            });
        }

        if(!empty($request->filter_by_organization)) {
            $user = $user->where('organization_id',$request->filter_by_organization);
        }

        if(!empty($request->filter_by_program)) {
            $user = $user->whereRaw('id = (SELECT
                    id
                FROM
                    '.with(new Self)->getTable().' AS s
                WHERE s.id =
                    (SELECT
                        supervisor_id
                    FROM
                        '.with(new ProgramSupervisor)->getTable().' AS ps
                    WHERE ps.program_id = '.$request->filter_by_program.' 
                    AND   ps.supervisor_id = '.with(new Self)->getTable().'.id 
                ))');
        }

        return DataTables::of($user)->editColumn('image',function($user){
            if(!empty($user->image)) 
            {
                $image ='<div class="for_user">
                            <img src="'.$user->image.'" alt ="'.$user->image.'">
                        </div>';
            } 
            else 
            {              
                $image ='<div class="for_user">
                            <img src="'.asset("images/noImg.jpg").'">
                        </div>';
            }
            return $image;

        })
         ->editColumn('first_name',function($user){
            return "<a href='".route('supervisor.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('supervisor.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('last_login',function($user){
            if(!empty($user->last_login)){
                return lastLoginDisplay($user->last_login);
            }
            return;
        })
        ->addColumn('organization_id',function($user){
            if(!empty($user->organization)){
                return $user->organization->name;
            }
            return;
        })
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programSupervisor)){
                foreach ($user->programSupervisor()->get() as $key => $value) {
                    $programs[] = $value->name;
                }
            }
            return implode(', ',$programs);
        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    supervisor_id
                    FROM
                    ".with(new ProgramSupervisor)->getTable()." AS ps
                    WHERE ps.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND ps.supervisor_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('organization_name', function ($query, $keyword) {
                $query->whereRaw("organization_id = (SELECT 
                    id
                    FROM
                    ".with(new Organization)->getTable()." AS o WHERE o.id = ".with(new Self)->getTable().".organization_id AND o.name like ?)", ["%{$keyword}%"]);
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
        ->addColumn('organization_name',function($user){
            if(!empty($user->organization)){
                return $user->organization->name;
            }
            return;
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

        ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('organization_name', '(SELECT name FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id IN (SELECT program_id FROM '.with(new ProgramSupervisor)->getTable().'  WHERE supervisor_id = '.with(new Self)->getTable().'.id 
                )) $1')
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        ->orderColumn('status', 'is_active $1') 
        // ->setRowId(function ($user) {
        //     return route('supervisor.edit',$user->id);
        // })
        ->rawColumns(['image','first_name', 'last_name','num_providers','num_users','num_users_goals','organization_name','programs','last_login','avg_goal_change','status'])->make(true);
    }

    public static function getOrganizationProviderDt($id,$request) {

        $user = Self::select('*')->whereUserTypeId('3');
        // $user = $user->whereHas('participantProvider',function($query) use($user) {
        //     $query->where('provider_id',$user->id);
        //  });
        $user = $user->where('organization_id',$id);
       
        if(!empty($request->filter_by_provider_type)) {
             $user = $user->whereHas('providerParticipant',function($query) use ($request){
                  $query->whereHas('provider',function($query1) use ($request){
                    $query1->whereHas('userDetail',function($query2) use ($request){
                        $query2->where('provider_type_id',$request->filter_by_provider_type);
                });
             });
           });         
        }

        if(!empty($request->filter_by_program)) {
            $user = $user->whereRaw('id = (SELECT
                    id
                FROM
                    '.with(new Self)->getTable().' AS s
                WHERE s.id =
                    (SELECT
                        provider_id
                    FROM
                        '.with(new ProgramProvider)->getTable().' AS ps
                    WHERE ps.program_id = '.$request->filter_by_program.' 
                    AND   ps.provider_id = '.with(new Self)->getTable().'.id 
                ))');
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
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->editColumn('first_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->last_name</a>";
        })
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programProvider)){
                foreach ($user->programProvider()->get() as $key => $value) {
                    $programs[] = "<a href='".route('program.edit',$value->id)."'>$value->name</a>";
                }
            }
            return implode(', ',$programs);
        })
        ->addColumn('provider_type',function($user){
            if(!empty($user->userDetail->provider_type_id)){
                 $provider = ProviderType::get()->where('id',$user->userDetail->provider_type_id)->first();
                return $provider['name'];
            }
            return;
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
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    provider_id
                    FROM
                    ".with(new ProgramProvider)->getTable()." AS ps
                    WHERE ps.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND   ps.provider_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id IN (SELECT program_id FROM '.with(new ProgramProvider)->getTable().'  WHERE provider_id = '.with(new Self)->getTable().'.id 
                )) $1')
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        
        ->setRowId(function ($user) {
            return route('provider.edit',$user->id);
        })
        ->rawColumns(['image','first_name', 'last_name','num_users','num_users_goals','programs','provider_type','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function getProviderDt($request) {

        $user = Self::select('*')->whereUserTypeId('3')->with(['userDetail','organization','providerSupervisor']);

        if(!empty($request->filter_by_provider_type)) {
            $user = $user->whereHas('userDetail',function($query) use ($request){
                $query->where('provider_type_id',$request->filter_by_provider_type);
            });
        }

        if(!empty($request->filter_by_organization)) {
            $user = $user->where('organization_id',$request->filter_by_organization);
        }

        if(Auth::user()->user_type_id == 2){
            $user = $user->whereHas('providerSupervisor',function($query){
                $query->where('supervisor_id',Auth::user()->id);
            });
        }

        if(Auth::user()->user_type_id == 5){
            $user = $user->whereHas('providerSupervisor',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            });
        }

        if(!empty($request->filter_by_program)) {
            $user = $user->whereRaw('id = (SELECT
                    id
                FROM
                    '.with(new Self)->getTable().' AS s
                WHERE s.id =
                    (SELECT
                        provider_id
                    FROM
                        '.with(new ProgramProvider)->getTable().' AS ps
                    WHERE ps.program_id = '.$request->filter_by_program.' 
                    AND   ps.provider_id = '.with(new Self)->getTable().'.id 
                ))');
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
         ->editColumn('first_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programProvider)){
                foreach ($user->programProvider()->get() as $key => $value) {
                    $programs[] = $value->name;
                }
            }
            return implode(', ',$programs);
        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    provider_id
                    FROM
                    ".with(new ProgramProvider)->getTable()." AS ps
                    WHERE ps.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND   ps.provider_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id IN (SELECT program_id FROM '.with(new ProgramProvider)->getTable().'  WHERE provider_id = '.with(new Self)->getTable().'.id 
                )) $1')
        ->filterColumn('organization_name', function ($query, $keyword) {
                $query->whereRaw("organization_id = (SELECT 
                    id
                    FROM
                    ".with(new Organization)->getTable()." AS o WHERE o.id = ".with(new Self)->getTable().".organization_id AND o.name like ?)", ["%{$keyword}%"]);
        })
        ->addColumn('provider_type',function($user){
            if(!empty($user->userDetail->provider_type_id)){
                 $provider = ProviderType::get()->where('id',$user->userDetail->provider_type_id)->first();
                return $provider['name'];
            }
            return;
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
        ->addColumn('organization_name',function($user){
            if(!empty($user->organization)){
                return $user->organization->name;
            }
            return;
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
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('organization_name', '(SELECT name FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

        ->orderColumn('provider_type','( SELECT name FROM '.with(new ProviderType)->getTable().' AS pt WHERE pt.id = (SELECT provider_type_id FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id)) $1')

        ->orderColumn('status', 'is_active $1')

        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        
        // ->setRowId(function ($user) {
        //     return route('provider.edit',$user->id);
        // })
        ->rawColumns(['image','first_name', 'last_name','num_users','num_users_goals','organization_name','programs','provider_type','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function getOrganizationParticipantDt($id,$request) {

        $user = Self::select('*')->whereUserTypeId(participantUserTypeId())->where('organization_id',$id);

        // $user = $user->whereHas('participantProvider',function($query) use ($id){
        //             $query->whereHas('participant',function($query2) use ($id){
        //                 $query2->where('organization_id',$id);
        //     });
        // });

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
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    participant_id
                    FROM
                    ".with(new ProgramParticipant)->getTable()." AS pp
                    WHERE pp.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND   pp.participant_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })
        ->filterColumn('provider_id', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    participant_id
                    FROM
                    ".with(new ParticipantProvider)->getTable()." AS partp
                    WHERE partp.provider_id IN ( SELECT id FROM ".with(new Self)->getTable()." WHERE first_name like ? )
                    AND   partp.participant_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
        })

        ->editColumn('first_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->editColumn('provider_id',function($user){
            $providers = array();
            if(!empty($user->participantProvider)){
                foreach ($user->participantProvider as $key => $value) {
                    
                        $userData = $value->provider;
                        $image = '<div class="weth"><div class="for_user"><img src="';
                        if(!empty($userData->image)) 
                        {
                            $image .= $userData->image.'" alt ="'.$userData->image;
                        } 
                        else 
                        {              
                            $image .= asset("images/noImg.jpg");
                        }
                        $image .= '"></div>';
                        if(!empty($userData->first_name) && !empty($userData->last_name)){
                             $image .= "<a href='".route('provider.edit',$userData->id)."'> ".$userData->full_name."</a></div>";                        }
                        $providers[] =  $image;
                }
            }
            return implode(' ',$providers);
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
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programParticipant)){
                foreach ($user->programParticipant()->get() as $key => $value) {
                    $programs[] =  "<a href='".route('program.edit',$value->id)."'>$value->name</a>";
                }
            }
            return implode(', ',$programs);
        })
         ->addColumn('status',function($user){
           return getUserStatus($user->is_active);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id IN (SELECT program_id FROM '.with(new ProgramParticipant)->getTable().'  WHERE participant_id = '.with(new Self)->getTable().'.id 
                )) $1')

        ->setRowId(function ($user) {
            return route('participant.edit',$user->id);
        })
        ->orderColumn('provider_id', '(SELECT
                       GROUP_CONCAT(p.first_name ORDER BY p.first_name ASC)
                    FROM
                        '.with(new Self)->getTable().' AS p
                    WHERE p.id IN (SELECT provider_id FROM '.with(new ParticipantProvider)->getTable().'  WHERE participant_id = '.with(new Self)->getTable().'.id 
                ))  $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
        
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
       
        ->rawColumns(['image','first_name', 'last_name','num_users_goals','updated_at','programs','provider_id','avg_goal_change','status'])->make(true);
    }

    public static function getParticipantDt($request) {
        $user = Self::select('*')->whereUserTypeId('4')->with('userDetail');   

        if(Auth::user()->user_type_id == 2){
            $user = $user->whereHas('participantProvider',function($query){
                $query->whereHas('provider',function($query1){
                    $query1->whereHas('providerSupervisor',function($query2){
                        $query2->where('supervisor_id',Auth::user()->id);
                    });
                });
            });
        }

        if(Auth::user()->user_type_id == 3){
            $user = $user->whereHas('participantProvider',function($query){
                $query->where('provider_id',Auth::user()->id);
            });
        }

        if(Auth::user()->user_type_id == 5){
            $user = $user->whereHas('participantProvider',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            });
        }
      
        if(!empty($request->filter_by_organization)) {
            $user = $user->where('organization_id',$request->filter_by_organization);
        }   

        if(!empty($request->filter_by_program)) {
            $user = $user->whereRaw('id = (SELECT
                    id
                FROM
                    '.with(new Self)->getTable().' AS s
                WHERE s.id =
                    (SELECT
                        participant_id
                    FROM
                        '.with(new ProgramParticipant)->getTable().' AS ps
                    WHERE ps.program_id = '.$request->filter_by_program.' 
                    AND   ps.participant_id = '.with(new Self)->getTable().'.id 
                ))');
        } 

        if(!empty($request->filter_by_provider_type)) {

             $user = $user->whereHas('participantProvider',function($query) use ($request){
                    $query->whereHas('provider',function($query1) use ($request){
                        $query1->whereHas('userDetail',function($query2) use ($request){
                            $query2->where('provider_type_id',$request->filter_by_provider_type);
                        });
                    });
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
         ->editColumn('first_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->addColumn('organization',function($user){
            if(!empty($user->organization)){
                return $user->organization->name;
            }
            return;
        })
        ->addColumn('providers',function($user){
            $providers = array();
            if(!empty($user->participantProvider)){
                foreach ($user->participantProvider as $key => $value) {
                    
                        $user = $value->provider;
                        $image = '<div class="weth"><div class="for_user"><img src="';
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
                             $image .= "<a href='".route('provider.edit',$user->id)."'> ".$user->full_name .getProgramName($value->program_id)."</a></div>";                        }
                        $providers[] =  $image;
                }
            }
            return implode(' ',$providers);
        })
        ->filterColumn('providers', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    participant_id
                    FROM
                    ".with(new ParticipantProvider)->getTable()." AS partp
                    WHERE partp.provider_id IN ( SELECT id FROM ".with(new Self)->getTable()." WHERE CONCAT(first_name,' ',last_name) like ? )
                    AND partp.participant_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
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
        ->filterColumn('organization', function ($query, $keyword) {
                $query->whereRaw("organization_id = (SELECT 
                    id
                    FROM
                    ".with(new Organization)->getTable()." AS o WHERE o.id = ".with(new Self)->getTable().".organization_id AND o.name like ?)", ["%{$keyword}%"]);
        })
        ->orderColumn('organization', '(SELECT name FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

        ->orderColumn('providers', '(SELECT
                       GROUP_CONCAT(CONCAT(u.first_name," ",u.last_name)  ORDER BY CONCAT(u.first_name," ",u.last_name)  ASC)
                    FROM
                        '.with(new User)->getTable().' AS u
                    WHERE u.id IN (SELECT provider_id FROM '.with(new ParticipantProvider)->getTable().'  WHERE participant_id = '.with(new Self)->getTable().'.id 
        )) $1')

        ->orderColumn('organization_name', '(SELECT name FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        
        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

       ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('status', 'is_active $1') 
        // ->setRowId(function ($user) {
        //     return route('participant.edit',$user->id);
        // })
        ->rawColumns(['image','first_name', 'last_name','num_users_goals','updated_at','organization','providers','avg_goal_change','status'])->make(true);
    }

    public static function getSupervisorProviderDt($id,$request){
        $user = Self::select('*')->whereUserTypeId('3')->with(['userDetail','organization'])->whereHas('providerSupervisor',function($query) use ($id){
            $query->whereSupervisorId($id);
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
         ->editColumn('first_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('provider.edit',$user->id)."'>$user->last_name</a>";
        })
        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })
        ->addColumn('programs',function($user){
            $programs = array();
            if(!empty($user->programProvider)){
                foreach ($user->programProvider()->get() as $key => $value) {
                    $programs[] = $value->name;
                }
            }
            return implode(', ',$programs);
        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (SELECT
                    provider_id
                    FROM
                    ".with(new ProgramProvider)->getTable()." AS ps
                    WHERE ps.program_id IN ( SELECT id FROM ".with(new Program)->getTable()." WHERE name like ? )
                    AND   ps.provider_id = ".with(new Self)->getTable().".id 
                )", ["%{$keyword}%"]);
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
        ->addColumn('organization_name',function($user){
            if(!empty($user->organization)){
                return $user->organization->name;
            }
            return;
        })
        ->addColumn('avg_goal_change',function($user){
            if(!empty($user->userDetail->avg_goal_change)){
                return $user->userDetail->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('provider_type_id',function($user){
            if(!empty($user->userDetail)){
                return $user->userDetail->provider_type_id;
            }
            return 0;
        })
        ->addColumn('status',function($user){
            return getUserStatus($user->is_active);
        })

        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('avg_goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('organization_name', '(SELECT name FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')

        // ->setRowId(function ($user) {
        //     return route('provider.edit',$user->id);
        // })

        ->rawColumns(['image','first_name', 'last_name','num_users','num_users_goals','organization_name','programs','provider_type_id','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function getProviderParticipantDt($id,$request){
        $user = Self::select('*')->whereUserTypeId(participantUserTypeId())->with('userDetail')->whereHas('participantProvider',function($query) use ($id){
            $query->whereProviderId($id);
        });

        if(!empty($request->filter_by_participant)) {
            $user = $user->where('id',$request->filter_by_participant);
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
        ->editColumn('first_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('participant.edit',$user->id)."'>$user->last_name</a>";
        })
        ->addColumn('num_users_goals',function($user){
            if(!empty($user->userDetail->num_users_goals)){
                return $user->userDetail->num_users_goals;
            }
            return 0;
        })
         ->addColumn('goal_change',function($user){
            if(!empty($user->userDetail->avg_goal_change)){
                return $user->userDetail->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('status',function($user){
            return getUserStatus($user->is_active);
        })

        ->editColumn('updated_at',function($user){
            return lastUpdateDisplay($user->updated_at);
        })

        ->orderColumn('num_users_goals', '(SELECT num_users_goals FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')

        ->orderColumn('goal_change', '(SELECT avg_goal_change FROM '.with(new UserDetail)->getTable().' AS ud WHERE ud.user_id = '.with(new Self)->getTable().'.id) $1')
       
        ->rawColumns(['image','first_name', 'last_name','num_users_goals','updated_at','goal_change','status'])->make(true);
    }

    public static function getOrganizationAdminDt($id,$request){
        $user = Self::whereUserTypeId('5')->whereOrganizationId($id)->with(['userDetail','organization']);

        return DataTables::of($user)->editColumn('image',function($user){
            if(!empty($user->image)) 
            {
                $image ='<div class="for_user">
                            <img src="'.$user->image.'" alt ="'.$user->image.'">
                        </div>';
            } 
            else 
            {              
                $image ='<div class="for_user">
                            <img src="'.asset("images/noImg.jpg").'">
                        </div>';
            }
            return $image;

        })->editColumn('updated_at',function($user){
            if(!empty($user->updated_at)){
                return lastUpdateDisplay($user->updated_at);
            }
            return;
        })
        ->editColumn('first_name',function($user){
            return "<a href='".route('admin.edit',$user->id)."'>$user->first_name</a>";
        })
        ->editColumn('last_name',function($user){
            return "<a href='".route('admin.edit',$user->id)."'>$user->last_name</a>";
        })
        ->addColumn('num_providers',function($user){
            if(!empty($user->organization->num_providers)){
                return $user->organization->num_providers;
            }
            return 0;
        })
        ->addColumn('num_users',function($user){
            if(!empty($user->organization->num_users)){
                return $user->organization->num_users;
            }
            return 0;
        })
        ->addColumn('num_users_goals',function($user){
            if(!empty($user->organization->num_goals)){
                return $user->organization->num_goals ;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($user){
            if(!empty($user->organization->avg_goal_change)){
                return $user->organization->avg_goal_change;
            }
            return 0;
        })
        ->addColumn('status',function($user){
           return getUserStatus($user->is_active);
        })
        ->orderColumn('num_providers', '(SELECT num_providers FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        ->orderColumn('num_users', '(SELECT num_users FROM '.with(new Organization)->getTable().' AS org WHERE org.id = '.with(new Self)->getTable().'.organization_id) $1')
        ->setRowId(function ($user) {
            return route('admin.edit',$user->id);
        })->rawColumns(['image','first_name', 'last_name','num_providers','num_users','num_users_goals','updated_at','avg_goal_change','status'])->make(true);
    }

    public static function setParticipantGoalCount($participant_id){
        return Self::find($participant_id)->userDetail->setGoalCount(calculateParticipantGoalCount($participant_id));
    }

    public static function setProviderGoalCount($provider_id){
        return  Self::find($provider_id)->userDetail->setGoalCount(calculateProviderGoalCount($provider_id));
    }

    public static function setSupervisorGoalCount($supervisor_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  Self::find($supervisor_id)->userDetail->setGoalCount(calculateSupervisorGoalCount($provider_ids));
    }

    public static function setOrganizationGoalCount($organization_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereOrganizationId($organization_id)->get()->pluck('id')->toArray();
        return Organization::find($organization_id)->setGoalCount(calculateSupervisorGoalCount($provider_ids));
    }

    public static function setParticipantAvgGoal($participant_id){
        return Self::find($participant_id)->userDetail->setAvgGoal(calculateParticipantAvgGoal($participant_id));
    }

    public static function setProviderAvgGoal($provider_id){
        return  Self::find($provider_id)->userDetail->setAvgGoal(calculateProviderAvgGoal($provider_id));
    }

    public static function setSupervisorAvgGoal($supervisor_id){
      
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  Self::find($supervisor_id)->userDetail->setAvgGoal(calculateSupervisorAvgGoal($provider_ids));
    }

    public static function setOrganizationAvgGoal($organization_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereOrganizationId($organization_id)->get()->pluck('id')->toArray();
        return Organization::find($organization_id)->setAvgGoal(calculateSupervisorAvgGoal($provider_ids));
    }

    public static function setProviderUserCount($provider_id){
        return  Self::find($provider_id)->userDetail->setUserCount(calculateProviderUserCount($provider_id));
    }

    public static function setSupervisorUserCount($supervisor_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  Self::find($supervisor_id)->userDetail->setUserCount(calculateSupervisorUserCount($provider_ids));
    }

    public static function setOrganizationUserCount($organization_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereOrganizationId($organization_id)->get()->pluck('id')->toArray();
        return Organization::find($organization_id)->setUserCount(calculateSupervisorUserCount($provider_ids));
    }

    public static function setSupervisorProviderCount($supervisor_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  Self::find($supervisor_id)->userDetail->setProviderCount(calculateSupervisorProviderCount($provider_ids));
    }

    public static function setOrganizationProviderCount($organization_id){
        $provider_ids = Self::select('id')->whereUserTypeId('3')->whereOrganizationId($organization_id)->get()->pluck('id')->toArray();
        return Organization::find($organization_id)->setProviderCount(calculateSupervisorProviderCount($provider_ids));
    }  
    
    public static function getUserDataByEmail($email) {

        $UserData = DB::table(with(new Self)->getTable())->where('email', $email)->first();
        if(!empty($UserData)){
            return $UserData;
        } else {
            return false;
        }
    }
}
