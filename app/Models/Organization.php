<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use Illuminate\Support\Facades\Storage;
use App\Traits\OrganizationTrait;
use App\User;
use App\Models\Program;
use App\BaseModel;
use Auth;

class Organization extends BaseModel
{

    use OrganizationTrait;
    protected $table = 'organizations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name','contact_email','contact_phone','image','logo_image','date_added','address','city','state_id','zip','record_num','num_users','num_providers','num_goals','avg_goal_change','notes','program_label','supervisor_label','provider_label','participant_label','is_active','created_by','last_modified_by'
    ];

    public function getAvgGoalChangeAttribute(){
        return !empty($this->attributes['avg_goal_change']) ? numFormatWithDecimal($this->attributes['avg_goal_change']) : 0;
    }

    public function getImageAttribute() {    
        return !empty($this->attributes['image']) && file_exists(Storage::path(config('constants.organization_image_storage_path').$this->attributes['image'])) ? url(Storage::url(config('constants.organization_image_storage_path').$this->attributes['image'])) : ''; 
    }

    public function getLogoImageAttribute() {    
        return !empty($this->attributes['logo_image']) && file_exists(Storage::path(config('constants.organization_logo_storage_path').$this->attributes['logo_image'])) ? url(Storage::url(config('constants.organization_logo_storage_path').$this->attributes['logo_image'])) : ''; 
    }

    public function provider(){
        return $this->hasOne('App\User','user_id','id');
    }

    // programs
    public function programs(){
        return $this->hasMany('App\Models\Program','organization_id', 'id');
    }

    public function organizationOrgType(){
        return $this->belongsToMany('App\Models\OrganizationType', 'organization_org_type', 'organization_id', 'org_type_id')->withTimestamps();
    }

    public static function getOrganizationDt($request){
    	$organization = Self::withoutGlobalScopes()->select('*');

        if(!empty($request->filter_by_program)) {
            $organization = $organization->whereRaw('id = (SELECT
                    id
                FROM
                    '.with(new Self)->getTable().' AS o
                WHERE o.id =
                    (SELECT
                        organization_id
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.id = '.$request->filter_by_program.' 
                    AND   p.organization_id = '.with(new Self)->getTable().'.id 
                ))');
        }
        return DataTables::of($organization)
        ->addColumn('location',function($organization){
            return $organization->city;
        })
        ->addColumn('num_providers',function($organization){
            if(!empty($organization->num_providers)){
                return $organization->num_providers;
            }
            return 0;
            
        })
        ->addColumn('num_users',function($organization){
            if(!empty($organization->num_providers)){
                return $organization->num_users;
            }
            return 0;
        })
        ->addColumn('avg_goal_change',function($organization){
            if(!empty($organization->num_providers)){
                return $organization->avg_goal_change;
            }
            return 0;
        })
        ->editColumn('name',function($organization){
            return '<a href="'.route('organization.edit',$organization->id).'">'.$organization->name.'</a>';
        })
        ->addColumn('programs',function($organization){
            $programs = array();
            if(!empty($organization->programs)){
                foreach ($organization->programs()->orderBy('name', 'ASC')->get() as $key => $value) {
                    $programs[] = '<a href="'.route('program.edit',$value->id).'">'.$value->name.'</a>';
                }
                 return implode(', ',$programs);
            }
           return 0;

        })
        ->filterColumn('programs', function ($query, $keyword) {
            $query->whereRaw("id = (
                 SELECT organization_id FROM ".with(new Program)->getTable()." as p WHERE p.organization_id = ".with(new Self)->getTable().".id  AND name like ? LIMIT 1
                )", ["%{$keyword}%"]);
        })
        ->orderColumn('programs', '(SELECT
                       GROUP_CONCAT(p.name ORDER BY p.name ASC)
                    FROM
                        '.with(new Program)->getTable().' AS p
                    WHERE p.organization_id = '.with(new Self)->getTable().'.id 
                ) $1')
        ->orderColumn('num_providers', 'num_providers $1')
        
        ->orderColumn('num_users', 'num_users $1')

        ->orderColumn('avg_goal_change', 'avg_goal_change $1')
        
        ->orderColumn('location', 'city $1')

        // ->setRowId(function ($organization) {
        //     return route('organization.edit',$organization->id);
        // })
        ->rawColumns(['name', 'location','num_providers','num_users','programs','avg_goal_change'])->make(true);
    }
}