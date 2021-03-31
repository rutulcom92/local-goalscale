<?php

namespace App\Models;

use App\BaseModel;

class ProviderSupervisor extends BaseModel
{
    protected $table = 'provider_supervisors';

    protected $primarykey = 'id';


    protected $fillable = [
        'provider_id','supervisor_id','program_id','is_active','created_by','last_modified_by'
    ];

    //program
    public function provider()
    {
        return $this->belongsTo('App\User', 'provider_id','id');
    }

    // supervisor
    public function supervisor()
    {
        return $this->hasOne('App\User','id', 'supervisor_id');
    }
}
