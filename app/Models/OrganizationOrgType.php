<?php

namespace App\Models;

use App\BaseModel;

class OrganizationOrgType extends BaseModel
{

    protected $table = 'organization_org_type';

    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id','org_type_id','is_active','created_by','last_modified_by'
    ];

}