<?php

namespace App\Models;

use App\BaseModel;
use App\User;
use App\Traits\UserDetailTrait;

class UserDetail extends BaseModel
{
    use UserDetailTrait;
    
	  protected $table = 'user_details';

   	protected $primaryKey = 'id';

   	protected $fillable = [
        'gender','program_id','provider_id', 'dob', 'user_id','avg_goal_change','num_goals','provider_type_id','num_users_goals','num_users','num_providers','created_by','last_modified_by'
    ];

    // provider
    public function provider()
    {
        return $this->belongsTo('App\User', 'provider_id','id');
    }

    public function getAvgGoalChangeAttribute(){
        return !empty($this->attributes['avg_goal_change']) ? numFormatWithDecimal($this->attributes['avg_goal_change']) : 0;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }
}