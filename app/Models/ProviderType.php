<?php

namespace App\Models;

use App\BaseModel;

class ProviderType extends BaseModel
{
    protected $table = 'provider_types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name','org_type_id', 'is_active','created_by','last_modified_by'
    ];

    public function organizationOrgType(){
        return $this->belongsToMany('App\Models\OrganizationType', 'organization_org_type', 'organization_id', 'org_type_id')->withTimestamps();
    }

    public function provider(){
        return $this->hasMany('App\Models\UserDetail', 'provider_type_id', 'id');
    }
}
