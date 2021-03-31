<?php

namespace App\Models;

use App\BaseModel;

class OrganizationType extends BaseModel
{
    protected $table = 'org_types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'is_active', 'created_by', 'last_modified_by',
    ];

    // Tags
    public function tags()
    {
        return $this->hasMany('App\Models\Tag', 'org_type_id', 'id');
    }

    // Presenting Challenges Tags
    public function presentingChallengeTags()
    {
        return $this->hasMany('App\Models\Tag', 'org_type_id', 'id')->whereTagTypeId(1);
    }

    // Goal Topics Tags
    public function goalTopicTags()
    {
        return $this->hasMany('App\Models\Tag', 'org_type_id', 'id')->whereTagTypeId(2);
    }

    // Specialized Intervention Tags
    public function specializedInterventionTags()
    {
        return $this->hasMany('App\Models\Tag', 'org_type_id', 'id')->whereTagTypeId(3);
    }

     public function organizationOrgType()
    {
        return $this->hasMany('App\Models\OrganizationOrgType', 'org_type_id', 'id');
    }



}